<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Str;
use App\User;

class LogoutController extends Controller
{
    public function logout()
    {
        $apiToken = Str::random(10);
        if (auth::user()->update(['api_token'=>$apiToken])) { //update api_token
            return "You've logged out";
        }
    }
}
