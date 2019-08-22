<?php

namespace App\Http\Controllers;

use App\User;
use Str;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Validator;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *@param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index($api_token)
    {
//        $members = Member::latest()->paginate(5);
//        return view('products.index',compact('products'))
//            ->with('i', (request()->input('page', 1) - 1) * 5);
        $members = User::all();
        var_dump($api_token);
        if($api_token)
            return $this->sendResponse($members->toArray(), 'Members retrieved successfully.');
        else
            return 'You are not admin.';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
            'isAdmin' => $request['isAdmin'],
            'api_token'=> $apiToken,
        ]);

        if($create)
            return "Your api token is $apiToken";

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $member)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'max:12'],
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $member->email = $input['email'];
        $member->password = $input['password'];
        $member->save();

        return $this->sendResponse($member->toArray(), 'Member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $member)
    {
        $member->delete();

        return $this->sendResponse($member->toArray(), 'Member deleted successfully.');
    }
}
