<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    function sideBar(): JsonResponse
    {
        if (session('settings') && session('settings')['sideBar'] == ' collapsed') {
            session()->put(['settings' => ['sideBar' => '']]);
            return response()->json(['status' => true], 200);
        } else {
            session()->put(['settings' => ['sideBar' => ' collapsed']]);
            return response()->json(['status' => true], 200);
        }
    }
}
