<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Validator;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $members = Member::latest()->paginate(5);
//        return view('products.index',compact('products'))
//            ->with('i', (request()->input('page', 1) - 1) * 5);
        $members = Member::all();
        return $this->sendResponse($members->toArray(), 'Members retrieved successfully.');
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'max:12'],
        ]);

        //if(isAdmin)
        if(Member::create($request->all())){
            return redirect()->route('products.index')
            ->with('success', 'User created successfully.');
        }

        //else{
            //return 'User created successfully.;
        //}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
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
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return $this->sendResponse($member->toArray(), 'Member deleted successfully.');
    }
}
