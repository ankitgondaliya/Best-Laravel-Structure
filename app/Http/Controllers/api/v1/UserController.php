<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\{ChangePasswordRequest,UpdateProfileRequest};
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\{Hash,Auth};

class UserController extends Controller
{
    // user profile details API function.
    public function userProfile(){
        try{
            $user = Auth::user();
            $user = User::where('email',$user->email)->first()->makeHidden(['role', 'image']);
            return response()->json(['status' => true, 'message' => 'data fetched successfully!', 'data' => $user]);
        } catch(Exception $e) {
            return response()->json(['status' => false, 'message' => 'Something went wrong!','errorMessage'=>$e->getMessage()]);
        }
    }

    // user password change API function.
    public function ChangePassword(ChangePasswordRequest $request){
        try {
            $validData = $request->validated();
            $userId = Auth::user()->id;
            if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                return error('Invalid old password.');
            } else if ((Hash::check(request('password'), Auth::user()->password)) == true) {
                return error('Please enter a password which is not similar then current password.');
            } else {
                User::where('id', $userId)->update(['password' => bcrypt($validData['password'])]);
                return success('Password updated successfully.');
            }
        } catch (Exception $err) {
            return error('Something went wrong',$err->getMessage());
        }
    }

    // logout API function.
    public function logout(Request $request){
        try{
            $request->user()->token()->revoke();
            return success('Successfully logout');
        } catch(Exception $e) {
            return error('Something went wrong',$e->getMessage());
        }
    }

    // user profile update API function.
    public function updateProfile(UpdateProfileRequest $request){
        try {
            $validData = $request->validated();
            $validData['name'] = $request->name ?? "";
            $userId = Auth::user()->id;
            $user = User::activeUser()->where('id',$userId)->first();
            if($user == null){
                return error('User not found.');
            }
            $user->update($validData);
            return success('Profile updated successfully.');
        } catch (Exception $err) {
            return error('Something went wrong',$err->getMessage());
        }
    }
}
