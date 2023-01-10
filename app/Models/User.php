<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Client as OClient;
use GuzzleHttp\Client;
use Exception;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    public $table = 'users';


    const USERROLE = 0;
    const ADMINROLE = 1;
    const STATUSPENDING = 0;
    const STATUSVERIFIED = 1;
    const STATUSBLOCKED = 2;
    const STATUS = [
        "pending" => 0,
        "verified" => 1,
        "blocked" => 2
    ];


    public $fillable = [
        'name',
        'email',
        'user_name',
        'status',
        'role',
        'password',
        'image',
        'status',
        'device_token',
        'device_type',
        'email_verified_at'
    ];

    protected $hidden = [
        'password', 'remember_token', 'updated_at',
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'email_verified_at' => 'date:Y-m-d H:i:s'
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getImageAttribute($value)
    {
        if ($value == null) {
            return url('public/img/profile.png');
        }
        return url($value);
    }
    
    public function scopeRoleUser($query)
    {
        return $query->where('role', '!=', self::ADMINROLE);
    }

    public function scopeActiveUser($query)
    {
        return $query->where('role', self::USERROLE)->where('status', self::STATUSVERIFIED);
    }

    public static function checkEmailExists($request)
    {
        try {
            $user = User::roleUser()->where('email', $request->email)
                ->first();
            $exists = $user == null ?  false : true;
            $res =  ['status' => true, 'exists' => $exists];
        } catch (\Throwable $err) {
            return ['status' => false, 'exists' => false];
        }
        return $res;
    }

    public static function getTokenAndRefreshToken($email, $password)
    {
    	$oClient = OClient::where('password_client', 1)->first();
    	if (empty($oClient)) {
    		throw new Exception('password_client not found');
    	}
    	$http = new Client();
    	$response = $http->request('POST', url('oauth/token'), [
    		'form_params' => [
    			'grant_type' => 'password',
    			'client_id' => $oClient->id,
    			'client_secret' => $oClient->secret,
    			'username' => $email,
    			'password' => $password,
    			'scope' => '*',
    		],
    		'verify' => false,
    	]);
    	return json_decode((string) $response->getBody(), true);
    }

    public function loginResponse()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'email' => $this->email,
            'address' => $this->address,
            'email_verified'=>$this->status == self::STATUSVERIFIED? true:false,
            'provider'=> $this->provider??'email',
        ];
    }


}
