<?php

namespace App\Http\Controllers;

use App\File;
use App\Manual;
use Illuminate\Http\Request;

class ManualController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Manual  $manual
     * @return \Illuminate\Http\Response
     */
    public function show(Manual $manual)
    {
        $file = $manual->file;

        return [
            'condominium_id' => $manual->condominium_id,
            'file_id' => $manual->file_id,
            'file_name' => $file? $file->file : null,
            'name' => $manual->name,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Manual  $manual
     * @return \Illuminate\Http\Response
     */
    public function edit(Manual $manual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Manual  $manual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Manual $manual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Manual  $manual
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manual $manual)
    {

        if ($manual->file){
            $file = $manual->file;
            
            $manual->delete();
            
            return File::deleteFile($file);
            
        }else{
            $manual->delete();
            return response()->json([],204);
        }
    }

    public function getProjects(Request $request)
    {

        $manuals = Manual::whereCondominiumId($request->condominium_id)->get();

        $response=[];
        foreach ($manuals as $manual) {
            $response[] = [
                'id' => $manual->id,
                'condominium_id' => $manual->condominium_id,
                'file_id' => $manual->file_id,
                'name' => $manual->name,
                'created_at' => $manual->created_at,
                'updated_at' => $manual->updated_at,
                'file_name' => $manual->file? $manual->file->file:null
            ];
        }

        return $response;
    }

    public function uploadoFiles(Request $request){

        
        if ($request->hasFile('file')) {

            $create_file = File::createFile($request,'Manuals',null);

            Manual::create([
                'condominium_id' => $request->condominium_id,
                'file_id' => $create_file['file_id'],
                'name' => $request->name
            ]);
            
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

        $manual = Manual::find($request->manual_id);

        if ($manual) {
            # code...
            $file = File::find($manual->file_id);
    
            if ($file) {
                        
                $manual->file_id = null;
                $manual->save();

                return File::deleteFile($file);

            }else {
                $file_error = ['file' => ['file_id nao localizado']];
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $file_error],422);
            }

            return response()->json([],204);

        }else{
            $file_error = ['file' => ['O manual_id: '.$request->manual_id.' nao localizado']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $file_error],422);
        } 
        

    }

    public function updateFile(Request $request, $manual_id)
    {

        $manual = Manual::find($manual_id);

        if ($request->hasFile('file')) {
         
            $file_to_remove = $manual->file_id;
            
            $create_file = File::createFile($request,'Manuals',null);

            $manual->name = $request->name;
            $manual->file_id = $create_file['file_id'];
            $manual->save();
            $manual->refresh();
            
            $file = File::find($file_to_remove);
            
            if ($file) {
                
                $response_delete = File::deleteFile($file);
            }

            return $manual;

        }else{
            
            $manual = Manual::find($manual_id);
            $manual->name = $request->name;
            $manual->save();
            $manual->refresh();

            return $manual;

        }

    }
}
