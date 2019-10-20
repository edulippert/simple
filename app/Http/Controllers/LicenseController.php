<?php

namespace App\Http\Controllers;

use App\File;
use App\License;
use App\LicenseOption;
use Illuminate\Http\Request;

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
            'option_id' => 'required',
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
        $name = $file->name;
        $licensePath = '/licenses'.'/'.$file->id;
        $completePath = $licensePath;

       
        \File::deleteDirectory(\public_path($completePath));

        $license->delete();
        $file->delete();

        return response()->json([],204);
    }

    public function getLicenses(Request $request)
    {
        $licenses = License::getLicenses($request->condominium_id);
        //::with('licenses')->where('licenses.condominium_id',$request->condominium_id)->get();
        return $licenses;
    }

    public function uploadoFiles(Request $request, $id ){

        
        if ($request->hasFile('file')) {
            
            $file = File::create([
                'file' => $request->file('file')->getClientOriginalName(),
                'name' => $request->file('file')->hashName(),
                'type' => $request->file('file')->getClientOriginalExtension(),
                'subtype' => 'License'
            ]);

            $file->refresh();

            $fileName = $file->name;
            $equipment_path = '/licenses'.'/'.$file->id;
                 
            $path = $request->file('file')->move(public_path($equipment_path),$fileName);
            
            $fileUrl = url('/licenses'.'/'.$file->id.'/'.$fileName);

            License::create([
                'condominium_id' => $request->condominium_id,
                'option_id' => $id,
                'file_id' => $file->id,
                'description' => $request->description
            ]);
            
            return response()->json(['url' => $fileUrl],200);

        } else {
            return 'no file!';
        }      

    }

    public function downloadFile($file_id)
    {

        $file = File::find($file_id);

        if ($file) {
            $name = $file->name;
            $equipment_path = '/licenses'.'/'.$file->id.'/';
            $completePath = $equipment_path.$name;
        }

        return response()->download(\public_path($completePath),$file->file);
    }
}
