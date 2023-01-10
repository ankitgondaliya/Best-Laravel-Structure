<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\{UserRegisterRequest,UserLoginRequest,ForgotPasswordRequest,VerifyOtpRequest,ResetPasswordRequest, UserSocialLoginRequest};
use App\Mail\{SignupMail,ForgotPasswordMail};
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\{Crypt,URL,Mail,Auth, Validator};
use Illuminate\Http\Request;

class AuthController extends Controller
{
     // Register API function.
    public function Register(UserRegisterRequest $request){
    	try{
            $validData = $request->validated();
            $validData['role'] = User::USERROLE;
            $validData['provider'] = 'email';
            $validData['name'] = $request->name??"";
            $validData['user_agent'] = $request->header('User-Agent');
            $user = User::create($validData);
            $link = URL::to("verify-email/" . Crypt::encrypt($user->id));
            $email_data = ['name' =>  $user->name, 'link' =>  $link,];
            Mail::to($request->email)->send(new SignupMail($email_data));
            return success('Signup successfully, Please verify your email address.');
        } catch(Exception $e) {
            return error('Something went wrong',$e->getMessage());
        }
    }

    // Email verification API function.
    public function EmailVerification($id){
        $user = User::where('id', Crypt::decrypt($id))->where('status',User::STATUS['pending'])->first();
        if($user == null){
            abort(404);
        }
        $user->update(['status' => User::STATUS['verified'],'email_verified_at' => date('Y-m-d H:i:s')]);
        return view('templates.verified-success');
    }

    // ForgotPasword verification API function.
    public function ForgotPasword(ForgotPasswordRequest $request){
        try{
            $post = $request->all();
            $user = User::activeUser()->where('email', $post['email'])->first();
            if($user == null){
                return response()->json(['status' => false, 'message' => 'No user found with this email!']);
            }
            $otp = PasswordReset::GenerateOtp();
            $expireTime = Carbon::now()->subMinute(60)->toDateTimeString();
            PasswordReset::where('email',$request->email) //delete expired token
            ->where('created_at','<', $expireTime)
            ->delete();
            PasswordReset::create(['email'=>$request->email, 'token' => $otp]);
            $mailData = [
                'name'      =>  $user->name,
                'otp'       => $otp,
                'expire'    => PasswordReset::EXPIRE,
            ];
            Mail::to($request->email)->send(new ForgotPasswordMail($mailData));
            return success('Forgot password OTP sent on your email.');
        } catch(Exception $e) {
            return error('Something went wrong',$e->getMessage());
        }
    }

    // verifyOtp verification API function.
    public function verifyOtp(VerifyOtpRequest $request){
        try {
            $validData = $request->validated();
            $otp = PasswordReset::checkOtp($validData);
            $res = $otp ? success("OTP verified successfully.") : error('Invalid OTP');
            return $res;
        } catch(Exception $e) {
            return error('Something went wrong',$e->getMessage());
        }
    }

    // resetPassword verification API function.
    public function resetPassword(ResetPasswordRequest $request) {
		try{
    		$validData = $request->validated();
    		$user = User::activeUser()->where('email',$validData['email'])->first();
            $otpVerified = PasswordReset::checkOtp($validData);
            if($user == null || !$otpVerified){
                return error('Invalide request');
            }
            $udateData['password'] = $validData['password'];
            $user->update($udateData);
            PasswordReset::where('email',$validData['email'])->delete();
            return success('Passowrd reset successfully.');
    	} catch(Exception $e) {
            return error('Something went wrong',$e->getMessage());
    	}
    }

    /**
     * resendActivation verification API function.
     *
     *
     */
    public function resendActivation(ForgotPasswordRequest $request)
	{
		try {
		    $user  = User::where('email',$request->email)->first();

            if(!$user){
                return error('User not found');
            }
            elseif(isset($user->status) &&  $user->status == User::STATUSVERIFIED){
                return error('User already verified');
            }
            else{
            $link = URL::to("verify-email/" . Crypt::encrypt($user->id));
            $email_data = ['name' =>  $user->name, 'link' =>  $link,];
            Mail::to($request->email)->send(new SignupMail($email_data));
			return success('Link send successfully, Please check mail box for email verification.');
            }
		} catch (Exception $err) {
            return error('Something went wrong',$err->getMessage());
		}
	}

    /**
     * signIn verification API function.
     *
     *
     */
    public function signIn(UserLoginRequest $request){
    	try{
            $validData = $request->all();
            if(Auth::attempt(['email' => $validData['email'], 'password' => $validData['password']])) {
                $user = User::roleUser()->where('id',Auth::user()->id)->first();
                if($user->status == User::STATUSVERIFIED){
                  if(isset($validData['device_token']) && !empty($validData['device_token'])){
                    $user->update(['device_token' => $validData['device_token']]);
                  }
                $tokenBody = User::getTokenAndRefreshToken($validData['email'],$validData['password']);
					return loginAndSignupSuccess('Login successful',$tokenBody,$user->loginResponse());
                }
                else {
                    return error('Please verify your email address!');
                }
            } else {
				return error('Login credentials are invalid!');
            }
        } catch(Exception $err) {
			return error('Something went wrong',$err->getMessage());
        }
    }

    /**
     * checkEmailExists verification API function.
     *
     *
     */
    public function checkEmailExists(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
				'email' => 'required|email',
			]);
			if ($validator->fails()) {
				return validatorError($validator);
			}
            $exists = false;
            $res = User::checkEmailExists($request->email);
            if($res['status'] == true){
                $exists = $res['exists'] ? true:false;
            }
            return success('success',['exists' => $exists]);
        } catch (\Throwable $err) {
            return error('Something went wrong',$err->getMessage());
        }
    }

}
