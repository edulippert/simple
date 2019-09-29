<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Company::all();
        //return  CompanyResource::collection($company); 
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
            'name' => 'required|unique:companies,name',
            'cnpj' => 'required|unique:companies,cnpj',
            'cep' => 'required',
            'address'=>'required',
            'complement'=>'required',
            'website'=>'required',
            'email'=>'required|email',
            'phone_number'=>'required',
            'responsible'=>'required'
        ]);

        $company = Company::create($attributes);
        return $company;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return $company;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {

        $attributes = request()->validate([
            'name' => 'required|unique:companies,name',
            'cnpj' => 'required',
            'cep' => 'required',
            'address'=>'required',
            'complement'=>'required',
            'website'=>'required',
            'email'=>'required|email',
            'phone_number'=>'required',
            'responsible'=>'required'
        ]);

        $company->fill($attributes);
        $company->save();
        return $company;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return response()->json([],204);
    }

}
