<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserCompany;
use App\UserCondominium;

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

    public function saveUserAndAssignments(Request $request)
    {
        $user = User::create([
            'role_id' => $request->role_id,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'id_number' => $request->id_number,
            'cep' => $request->cep,
            'address' => $request->address,
            'complement' => $request->complement,
            'phone_number' => $request->phone_number,
            'is_active' => $request->is_active,
        ]);
        $user->refresh();

        if ($user) {
            if ($request->company_id==-1) {
                $userCompany = UserCompany::create([
                  'user_id' => $user->id, 
                  'company_id' => null
                ]);
                $userCompany->refresh();
                UserCondominium::create([
                  'user_company_id'=>$userCompany->id,
                  'condominium_id'=>$request->condominium_id
                  ]);
                 
            }else{
                $userCompany = UserCompany::create([
                  'user_id' => $user->id,
                  'company_id' => $request->company_id
                ]);
          
                if ($request->condominium_id!=-1) {
                  UserCondominium::create([
                    'user_company_id'=>$userCompany->id,
                    'condominium_id'=>$request->condominium_id
                    ]);
                }
            }
        }

        return "ok";
        
    }
}
