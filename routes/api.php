<?php

use App\Http\Controllers\api\v1\{AuthController,UserController,LaughController, StaticPageController, VideoController};
use App\Http\Controllers\SiteVisitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function(){
	// User Authonticate
    Route::controller(AuthController::class)->group(function () {
        Route::post('signup','Register');
        Route::post('signin','signIn');
        Route::post('forgot-password','ForgotPasword');
        Route::post('verify-otp','verifyOtp');
        Route::post('reset-password','resetPassword');
        Route::post('resend-activation','resendActivation');
        Route::post('check-email-exists','checkEmailExists');
    });
	// Authenticate
	Route::group(['middleware' => ['auth:api']], function() {

        // User
        Route::controller(UserController::class)->group(function () {
            Route::get('profile','userProfile');
            Route::post('change-password','changePassword');
            Route::post('update-profile','updateProfile');
            Route::get('logout','logout');
        });

	});
});
