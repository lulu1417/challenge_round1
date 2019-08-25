<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Str;
use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->auth_email)->where('password', $request->auth_password)->first();
        $apiToken = Str::random(10);
        if ($user->update(['api_token'=>$apiToken])) { //update api_token
            if ($user->isAdmin)
                return "login as admin, your api token is $apiToken";
            else
                return "login as user, your api token is $apiToken";
        }
    }
}
