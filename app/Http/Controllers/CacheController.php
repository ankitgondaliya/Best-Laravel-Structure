<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CacheController extends Controller
{
    public function MigrateTable(){
    	Artisan::call('migrate');
    	return "Migration created";
    }

    public function cacheClear(){
    	Artisan::call('config:cache');
	    Artisan::call('cache:clear');
	    Artisan::call('route:clear');
	    Artisan::call('route:cache');
	    Artisan::call('config:clear');
	    Artisan::call('view:clear');
	    return "Cache is cleared";
    }

    public function Logout(){
    	Auth::logout();
    	return \Redirect::to("/login")
        ->with('message', array('type' => 'success', 'text' => 'You have successfully logged out'));
    }
}
