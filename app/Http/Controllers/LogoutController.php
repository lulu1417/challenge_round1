<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Str;
use App\User;

class LogoutController extends Controller
{
    public function logout()
    {
        if (auth::user()->update(['api_token'=>'logged out'])) { //update api_token
            return "You've logged out";
        }
    }
}
