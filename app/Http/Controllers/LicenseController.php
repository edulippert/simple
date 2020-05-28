<?php

namespace App\Http\Controllers;

use App\File;
use App\License;
use App\LicenseOption;
use Illuminate\Http\Request;
use PharIo\Manifest\License as PharIoLicense;

class LicenseController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'condominium_id' => 'required',
            'file_id' => '',
            'description' => 'required'
        ]);

        $license = License::create($attributes);

        return $license;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\License  $license
     * @return \Illuminate\Http\Response
     */
    public function show(License $license)
    {
        $file = $license->file;
        return [
            'condominium_id' => $license->condominium_id, 
            'file_id' => $license->file_id,
            'file_name' => $file ? $file->file : null,
            'description' => $license->description
        ];
        return $license;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\License  $license
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, License $license)
    {
        $attributes = request()->validate([
            'condominium_id' => 'required',
            'option_id' => 'required',
            'file_id' => '',
            'description' => 'required'
        ]);

        $license->update($attributes);

        return $license;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\License  $license
     * @return \Illuminate\Http\Response
     */
    public function destroy(License $license)
    {
       
        $file = $license->file;
        if ($file) {
            
            $name = $file->name;
            $licensePath = '/licenses'.'/'.$file->id;
            $completePath = $licensePath;
    
           
            \File::deleteDirectory(\public_path($completePath));
    
            $license->delete();
            $file->delete();
    
            
        }else{
            $license->delete();

        }

        return response()->json([],204);
    }

    public function getLicenses(Request $request)
    {

        $licenses = License::buildLicenseResponse($request->condominium_id);
       // $licenses = License::getLicenses($request->condominium_id);
        //::with('licenses')->where('licenses.condominium_id',$request->condominium_id)->get();
        return $licenses;
    }

    public function uploadoFiles(Request $request ){

        
        if ($request->hasFile('file')) {
            
            $create_file = File::createFile($request,'Licenses',null);

            License::create([
                'condominium_id' => $request->condominium_id,
                'file_id' => $create_file['file_id'],
                'description' => $request->description
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

        $license = License::find($request->license_id);
        
        if ($license) {
            
            $file = File::find($license->file_id);
    
            if ($file) {
                        
                $license->file_id = null;
                $license->save();
            
                return File::deleteFile($file);

            }else {
                $file_error = ['file' => ['file_id nao localizado']];
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $file_error],422);
            }

        }else{
            $file_error = ['file' => ['O license_id: '.$request->license_id.' nao localizado']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $file_error],422);
        } 

    }

    public function updateFile(Request $request, $project_id)
    {

        $license = License::find($project_id);

        if ($request->hasFile('file')) {
            
            $file_to_remove = $license->file_id;
            
            $create_file = File::createFile($request,'Licenses',null);
            
            $license->description = $request->description;
            $license->file_id = $create_file['file_id'];
            $license->save();
            $license->refresh();    

            $file = File::find($file_to_remove);
            if ($file) {
                
                $response_delete = File::deleteFile($file);
            }

            return $license;

        }else{
            
            $license = License::find($project_id);
            $license->description = $request->description;
            $license->save();

            return $license;
        }

        
    }
}
