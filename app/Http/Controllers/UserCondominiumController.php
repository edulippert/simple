<?php

namespace App\Http\Controllers;

use App\Condominium;
use App\UserCondominium;
use Illuminate\Http\Request;

class UserCondominiumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Condominium::where('user_id', auth()->user()->id);
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
            'condominium_id' => 'required',
            'user_id' => 'required'
        ]);

        $user_condominium = UserCondominium::create($attributes);

        return $user_condominium;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserCondominium  $userCondominium
     * @return \Illuminate\Http\Response
     */
    public function show(UserCondominium $userCondominium)
    {
        return $userCondominium;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserCondominium  $userCondominium
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserCondominium $userCondominium)
    {
        $attributes = request()->validate([
            'condominium_id' => 'required',
            'user_id' => 'required'
        ]);

        $userCondominium->update($attributes);

        return $userCondominium;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserCondominium  $userCondominium
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserCondominium $userCondominium)
    {
        $userCondominium->delete();
    }
}
