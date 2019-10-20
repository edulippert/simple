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
        //
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
        $file = $manual->file;
        $name = $file->name;
        $licensePath = '/manuals'.'/'.$file->id;
        $completePath = $licensePath;

       
        \File::deleteDirectory(\public_path($completePath));

        $manual->delete();
        $file->delete();

        return response()->json([],204);
    }

    public function getProjects(Request $request)
    {
        $projects = Manual::whereCondominiumId($request->condominium_id)->get();
        return $projects;
    }

    public function uploadoFiles(Request $request){

        
        if ($request->hasFile('file')) {
            
            $file = File::create([
                'file' => $request->file('file')->getClientOriginalName(),
                'name' => $request->file('file')->hashName(),
                'type' => $request->file('file')->getClientOriginalExtension(),
                'subtype' => 'Manual'
            ]);

            $file->refresh();

            $fileName = $file->name;
            $manual_path = '/manuals'.'/'.$file->id;
                 
            $path = $request->file('file')->move(public_path($manual_path),$fileName);
            
            $fileUrl = url('/manuals'.'/'.$file->id.'/'.$fileName);

            Manual::create([
                'condominium_id' => $request->condominium_id,
                'file_id' => $file->id,
                'name' => $request->name
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
            $manual_path = '/manuals'.'/'.$file->id.'/';
            $completePath = $manual_path.$name;
        }

        return response()->download(\public_path($completePath),$file->file);
    }
}
