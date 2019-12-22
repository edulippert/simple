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
        
        return User::with('role')->with('user_companies.user_condominiums')->get();
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
        return response()->json([],'204');
    }

    public function showUserAndAssignments($id){
        return User::showUserAndAssignments($id);
    }

    public function deleteUserAndAssignments($id){
        
        $user_assignments = User::find($id);
      
        $user_assignments->delete();
        return response()->json([],'204');
    }

    public function getUsersAndAssignments()
    {
        return User::buildUserReponse();
        return User::getUserAndAssignments();
    }

    public function saveUserAndAssignments(Request $request)
    {
        $attributes = request()->validate([
            'role_id' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'id_number' => 'required|unique:users',
            'cep' => 'required',
            'address' => 'required',
            'complement' => 'required',
            'phone_number' => 'required',
            'is_active' => '',
        ]);
        
        $attributes['password'] = bcrypt($attributes['password']);

        $user = User::create($attributes);

        // $user = User::create([
        //     'role_id' => $request->role_id,
        //     'username' => $request->username,
        //     'email' => $request->email,
        //     'password' => bcrypt($request->password),
        //     'id_number' => $request->id_number,
        //     'cep' => $request->cep,
        //     'address' => $request->address,
        //     'complement' => $request->complement,
        //     'phone_number' => $request->phone_number,
        //     'is_active' => $request->is_active,
        // ]);
        $user->refresh();

        if ($user) {
            if ($request->company_id==-1 && $request->condominium_id!=-1) {
                $userCompany = UserCompany::create([
                  'user_id' => $user->id, 
                  'company_id' => null
                ]);
                $userCompany->refresh();

                UserCondominium::create([
                    'user_company_id'=>$userCompany->id,
                    'condominium_id'=>$request->condominium_id
                ]);
            
                 
            }elseif ($request->company_id!=-1){
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

        return $user;
        
    }

    public function updateUserAndAssignments(Request $request,$id)
    {

        $user = User::find($id);
        $user->role_id = $request->role_id;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->id_number = $request->id_number;
        $user->cep = $request->cep;
        $user->address = $request->address;
        $user->complement = $request->complement;
        $user->phone_number = $request->phone_number;
        $user->is_active = $request->is_active;

        if ($request->company_id!=-1){

            if ($user->user_companies->first()){
                
                $user->user_companies->first()->company_id=$request->company_id;
                        
                if ($request->condominium_id != -1){
                
                    if ($user->user_companies->first()->user_condominiums->first()){
                        
                        $user->user_companies->first()->user_condominiums->condominium_id=$request->condominium_id;        
                    }else{
                        UserCondominium::create([
                            'user_company_id'=>$user->user_companies->first()->id,
                            'condominium_id'=>$request->condominium_id
                        ]);
                    } 
                }else{
                    if ($user->user_companies->first()->user_condominiums->first()){
                        $user_condominium = UserCondominium::find($user->user_companies->first()->user_condominiums->first()->id);
                        $user_condominium->delete();
                    }
                }   

            }else{
                $userCompany = UserCompany::create([
                    'user_id' => $user->id,
                    'company_id' => $request->company_id
                ]);

                $userCompany->refresh();

                if ($request->condominium_id != -1){
                    UserCondominium::create([
                        'user_company_id'=>$userCompany->id,
                        'condominium_id'=>$request->condominium_id
                    ]);
                }
            }

        }else{//nenhum company

            if ($request->condominium_id == -1) {//Todos condominios
                
                if ($user->user_companies->first()){

                    if ($user->user_companies->first()->user_condominiums->first()){
                        $user_condominium = UserCondominium::find($user->user_companies->first()->user_condominiums->first()->id);
                        $user_condominium->delete();
                    }
                    $user_company = UserCompany::find($user->user_companies->first()->id);
                    $user_company->delete();
                }
            }else{
                
                if ($user->user_companies->first()){

                    $user->user_companies->first()->company_id=null;
                    
                    if ($user->user_companies->first()->user_condominiums->first()){
                
                        $user->user_companies->first()->user_condominiums->condominium_id=$request->condominium_id;     
                    
                    }else{
                        UserCondominium::create([
                            'user_company_id'=>$$user->user_companies->first()->id,
                            'condominium_id'=>$request->condominium_id
                        ]);
                    }
                }else{
                    
                    $userCompany = UserCompany::create([
                        'user_id' => $user->id, 
                        'company_id' => null
                    ]);
                    $userCompany->refresh();
      
                    UserCondominium::create([
                        'user_company_id'=>$userCompany->id,
                        'condominium_id'=>$request->condominium_id
                    ]);
                }
            }
        }

        $user->push();

        $user->refresh();

        return $user;
        
    }
}
