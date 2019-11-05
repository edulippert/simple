<?php

namespace App\Http\Controllers;

use App\File;
use App\Contract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contract = Contract::create($request->all());
        return $contract;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        return $contract;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract $contract)
    {
        $contract->fill($request->all());
        $contract->save();
        return $contract;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract)
    {
        $contract->delete();
        return response()->json([],204);
    }

    public function getContracts(Request $request)
    {
        //$contracts = Contract::whereCondominiumId($request->condominium_id)->get();
        $contracts = Contract::buildContractsReponse($request->condominium_id);
        return $contracts;
    }

    public function uploadoFiles(Request $request){

        if ($request->hasFile('file')) {
            
            $file = File::create([
                'file' => $request->file('file')->getClientOriginalName(),
                'name' => $request->file('file')->hashName(),
                'type' => $request->file('file')->getClientOriginalExtension(),
                'subtype' => 'Contracts'
            ]);

            $file->refresh();

            $fileName = $file->name;
            $contract_path = '/contracts'.'/'.$file->id;
                 
            $path = $request->file('file')->move(public_path($contract_path),$fileName);
            
            $fileUrl = url('/contracts'.'/'.$file->id.'/'.$fileName);

            $request->request->add(['file_id'=> $file->id]);
            
            
            $attributes = request()->validate([
                'condominium_id' => 'required',
                'file_id' => 'required',
                'name' => 'required',
                'description' => '',
                'total_cost' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'contact_name' => 'required',
                'contact_email' => '',
                'contact_phone_number' => 'required'
            ]);

            Contract::create($attributes);

            return response()->json(['url' => $fileUrl],200);

        } else {

            $file_error = ['file' => ['Arquivo obrigatorio']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $file_error],422);
        }      

    }

    public function downloadFile($file_id)
    {

        $file = File::find($file_id);

        if ($file) {
            $name = $file->name;
            $contract_path = '/contracts'.'/'.$file->id.'/';
            $completePath = $contract_path.$name;
        }

        return response()->download(\public_path($completePath),$file->file);
    }

    public function deleteFile(Request $request)
    {

        $contract = Contract::find($request->contract_id);
        
        $file = File::find($request->file_id);

        $licensePath = '/contracts'.'/'.$file->id;
        $completePath = $licensePath;

        \File::deleteDirectory(\public_path($completePath));

        $contract->file_id = null;
        $contract->save();
        $file->delete();

        return response()->json([],204);

    }

    public function updateFile(Request $request, $contract_id)
    {

        if ($request->hasFile('file')) {
            
            $file = File::create([
                'file' => $request->file('file')->getClientOriginalName(),
                'name' => $request->file('file')->hashName(),
                'type' => $request->file('file')->getClientOriginalExtension(),
                'subtype' => 'Project'
            ]);

            $file->refresh();

            $fileName = $file->name;
            $project_path = '/contracts'.'/'.$file->id;
                 
            $path = $request->file('file')->move(public_path($project_path),$fileName);
            
            $fileUrl = url('/contracts'.'/'.$file->id.'/'.$fileName);

            $request->request->add(['file_id'=> $file->id]);
            
            
            $attributes = request()->validate([
                'condominium_id' => 'required',
                'file_id' => 'required',
                'name' => 'required',
                'description' => '',
                'total_cost' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'contact_name' => 'required',
                'contact_email' => '',
                'contact_phone_number' => 'required'
            ]);


            $contract = Contract::fill($attributes);
            
        }else{
            
            $attributes = request()->validate([
                'condominium_id' => 'required',
                'name' => 'required',
                'description' => '',
                'total_cost' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'contact_name' => 'required',
                'contact_email' => '',
                'contact_phone_number' => 'required'
            ]);
            $contract = Contract::fill($attributes);
          

        }


        return $contract;
    }
}
