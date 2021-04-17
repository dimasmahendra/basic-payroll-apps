<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class CommonHelper
{
    public static function getDp()
    {
        if (Auth::check() && Auth::user()->name) {
            $name = Auth::user()->name;
            $arr = explode(" ", $name);
            return (isset($arr[1]) ? ucfirst($arr[0][0].$arr[1][0]) : ucfirst($arr[0][0]));
        } else {
            return "-";
        }
    }
}

