<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Str;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Validator;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = User::all();
        $users = [
            'name' => Auth::user()->name,
            'mail' => Auth::user()->email,
            'password' => Auth::user()->password,
        ];
        if (Auth::user()->isAdmin)
            return $this->sendResponse($admins->toArray(), 'Members retrieved successfully.');
        else
            return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'max:12'],
        ]);

        $apiToken = Str::random(10);
        $create = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
//            'isAdmin' => $request['isAdmin'],
            'api_token' => $apiToken,
        ]);

        if ($create)
            return "Your api token is $apiToken";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'password' => ['string', 'min:6', 'max:12'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user = Auth::user();
        if ($user->update($request->all()))
            return $this->sendResponse($user->toArray(), 'Member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $users
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $users)
    {
        if (Auth::user()->isAdmin){
            if ($users->delete())
                return $this->sendResponse($users->toArray(), 'Member deleted successfully.');
        }
        else
            return "You have no authority to delete";

    }
}
