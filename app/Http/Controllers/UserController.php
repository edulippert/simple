<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('role')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'role_id' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'id_number' => '',
            'cep' => '',
            'address' => '',
            'complement' => '',
            'phone_number' => '',
            'is_active' => '',
        ]);

        $attributes['password'] = bcrypt($attributes['password']);

        $user = User::create($attributes);

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $attributes = request()->validate([
            'role_id' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'id_number' => '',
            'cep' => '',
            'address' => '',
            'complement' => '',
            'phone_number' => '',
            'is_active' => '',
        ]);

        $attributes['password'] = bcrypt($attributes['password']);

        $user->update($attributes);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
