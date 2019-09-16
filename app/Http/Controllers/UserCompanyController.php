<?php

namespace App\Http\Controllers;

use App\Condominium;
use App\UserCompany;
use App\UserCondominium;
use Illuminate\Http\Request;

class UserCompanyController extends Controller
{
  
  public function storeCompanies(Request $request)
  {
    if ($request->company_id==-1) {
      $userCompany = UserCompany::create([
        'user_id' => $request->user_id, 
        'company_id' => null
      ]);
      $userCompany->refresh();
      UserCondominium::create([
        'user_company_id'=>$userCompany->id,
        'condominium_id'=>$request->condominium_id
        ]);
       
    }else{
      $userCompany = UserCompany::create([
        'user_id' => $request->user_id,
        'company_id' => $request->company_id
      ]);

      if ($request->condominium_id!=-1) {
        UserCondominium::create([
          'user_company_id'=>$userCompany->id,
          'condominium_id'=>$request->condominium_id
          ]);
      }
    }
    return response()->json(['message' => 'Cadastrado com sucesso!']);
  }

}
