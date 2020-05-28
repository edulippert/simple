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

        $file = $contract->file;

        return [
            'id' => $contract->id,
            'condominium_id' => $contract->condominium_id,
            'file_id' => $contract->file_id,
            'file_name' => $file? $file->file : null,
            'name' => $contract->name,
            'description' => $contract->description,
            'total_cost' => $contract->total_cost,
            'start_date' => $contract->start_date,
            'end_date' => $contract->end_date,
            'contact_name' => $contract->contact_name,
            'contact_email' => $contract->contact_email,
            'contact_phone_number' => $contract->contact_phone_number
        ];
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
        if($contract->file){
            $file = $contract->file;
            $name = $file->name;
            $contractPath = '/contracts'.'/'.$file->id;
            $completePath = $contractPath;

            
            \File::deleteDirectory(\public_path($completePath));

            $contract->delete();
            $file->delete();
        }else{

            $contract->delete();

        }

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

            $create_file = File::createFile($request,'Contracts',null);

            $request->request->add(['file_id'=> $create_file['file_id']]);
            
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

            return response()->json(['url' => $create_file['file_url']],200);

        } else {

            $file_error = ['file' => ['Arquivo obrigatorio']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $file_error],422);
        }      

    }

    public function downloadFile($file_id)
    {
        return File::downloadFile($file_id);
    }

    public function deleteFile(Request $request)
    {

        $contract = Contract::find($request->contract_id);
       
        if ($contract) {
           
            $file = File::find($contract->file_id);

            if ($file) {
                        
                $contract->file_id = null;
                $contract->save();

                return File::deleteFile($file);

            }else {
                $file_error = ['file' => ['file_id nao localizado']];
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $file_error],422);
            }      
    
        }else {
            $file_error = ['file' => ['contract_id: '.$request->contract_id.' nao localizado']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $file_error],422);
        }             

    }

    public function updateFile(Request $request, $contract_id)
    {

        $contract = Contract::find($contract_id);

        if ($request->hasFile('file')) {
            
            $file_to_remove = $contract->file_id;
            
            $create_file = File::createFile($request,'Contracts',null);

            $request->request->add(['file_id'=> $create_file['file_id']]);
            
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

            $contract->fill($attributes);
            $contract->save();
            $contract->refresh();

            $file = File::find($file_to_remove);
            if ($file) {
                
                $response_delete = File::deleteFile($file);
            }

            return $contract;
        
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
            
            $contract->fill($attributes);
            $contract->save();    
            return $contract;    
        }

        
    }
}
