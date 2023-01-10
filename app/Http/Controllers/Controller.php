<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    function __construct()
    {
        $timezone = request()->timezone && request()->timezone !="" ? request()->timezone : $timezone = 'Europe/London';
        date_default_timezone_set($timezone);
    }
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function escape_like($string)
    {
        $search = array('%', '_');
        $replace   = array('\%', '\_');
        return str_replace($search, $replace, $string);
    }
}
