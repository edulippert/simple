<?php

namespace App\Http\Controllers;

use App\File;
use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
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
            'file_id' => 'required',
            'name' => 'required'
        ]);

        $project = Project::create($attributes);

        return $project;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
       //dd($project);

       $file = $project->file;

        return [
            'id' => $project->id,
            'name' => $project->name,
            'condominium_id' => $project->condominium_id,
            'file_id' => $project->file_id,
            'file_name' =>  ($file? $file->file:null)
        ]; 
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
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
            $project_path = '/projects'.'/'.$file->id;
                 
            $path = $request->file('file')->move(public_path($project_path),$fileName);
            
            $fileUrl = url('/projects'.'/'.$file->id.'/'.$fileName);
        }
        // $attributes = request()->validate([
        //     'condominium_id' => 'required',
        //     'file_id' => 'required',
        //     'name' => 'required'
        // ]);
        $project->name = $request->name;
        $project->file_id = $file->id;
        $project->save();


        return $project;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $file = $project->file;
        $name = $file->name;
        $licensePath = '/projects'.'/'.$file->id;
        $completePath = $licensePath;

       
        \File::deleteDirectory(\public_path($completePath));

        $project->delete();
        $file->delete();

        return response()->json([],204);
    }

    public function getProjects(Request $request)
    {
        $projects = Project::whereCondominiumId($request->condominium_id)->get();
        return $projects;
    }

    public function uploadoFiles(Request $request){

        
        if ($request->hasFile('file')) {
            
            $file = File::create([
                'file' => $request->file('file')->getClientOriginalName(),
                'name' => $request->file('file')->hashName(),
                'type' => $request->file('file')->getClientOriginalExtension(),
                'subtype' => 'Project'
            ]);

            $file->refresh();

            $fileName = $file->name;
            $project_path = '/projects'.'/'.$file->id;
                 
            $path = $request->file('file')->move(public_path($project_path),$fileName);
            
            $fileUrl = url('/projects'.'/'.$file->id.'/'.$fileName);

            Project::create([
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
            $project_path = '/projects'.'/'.$file->id.'/';
            $completePath = $project_path.$name;
        }

        return response()->download(\public_path($completePath),$file->file);
    }

    public function deleteFile(Request $request)
    {

        $project = Project::find($request->project_id);
        
        $file = File::find($request->file_id);

        $licensePath = '/projects'.'/'.$file->id;
        $completePath = $licensePath;

        \File::deleteDirectory(\public_path($completePath));

        $project->file_id = null;
        $project->save();
        $file->delete();

        return response()->json([],204);

    }

    public function updateFile(Request $request, $project_id)
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
            $project_path = '/projects'.'/'.$file->id;
                 
            $path = $request->file('file')->move(public_path($project_path),$fileName);
            
            $fileUrl = url('/projects'.'/'.$file->id.'/'.$fileName);
        }
        
        $project = Project::find($project_id);
        
        $project->name = $request->name;
        $project->file_id = $file->id;
        $project->save();


        return $project;
    }

}
