<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $products = Product::latest()->paginate(5);
//
//        return view('products.index',compact('products'))
//            ->with('i', (request()->input('page', 1) - 1) * 5);
        $members =Member::all();
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

        Member::create($request->all());

        return redirect()->route('products.index')
            ->with('success','User created successfully.');
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
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'max:12'],
        ]);

        $member->update($request->all());

        return redirect()->route('products.index')
            ->with('success','Product updated successfully');
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

        return redirect()->route('products.index')
            ->with('success','Product deleted successfully');
    }
}
