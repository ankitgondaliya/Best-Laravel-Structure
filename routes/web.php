<?php

use App\Http\Controllers\{StaticPageController,LaughReportController,HomeController,SettingController,CacheController,UserController,CategoryController, LaughController, VideoController};
use App\Http\Controllers\api\v1\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::Routes(['register' => false]);




// Authenticate
Route::group(['middleware' => ['auth','admin']], function () {

    Route::get('/', function(){
        return redirect('dashboard');
     });

    Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    // Admin Profile
    Route::controller(HomeController::class)->group(function () {
        Route::get('profiles', 'Profile')->name('admin.profile');
        Route::post('update_admin_profile', 'UpdateAdminProfile');
    });

    // Users
    Route::controller(UserController::class)->group(function () {
        Route::resource('users',UserController::class);
        Route::get('check_email_dublicate', 'CheckEmailDublicate');
        Route::get('check_username_dublicate', 'CheckUsernameDublicate');
        Route::post('multiple_user_delete','MultipleUserDelete');
    });

    // Static page
    Route::controller(StaticPageController::class)->group(function () {
        Route::get('static-pages/{slug}','index')->name('admin.static-page');
        Route::post('static-pages/store','store')->name('tatic-pages.store');
    });
});

// Command
Route::controller(CacheController::class)->group(function () {
    Route::get('cache-clear', 'cacheClear')->name('cacheClear');
    Route::get('migrate-tables', 'MigrateTable')->name('MigrateTable');
    Route::get('/logout', 'Logout')->name('Logout'); // Logout
});
Route::controller(AuthController::class)->group(function () {
    Route::get('verify-email/{id}', 'emailVerification');
});

