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
            
            $create_file = File::createFile($request,'Projects',null);

            $project->name = $request->name;
            $project->file_id = $create_file['file_id'];
            $project->save();
            $project->refresh();
            return $project;

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if ($project->file){
            
            $file = $project->file;

            $project->delete();

            return File::deleteFile($file);

        }else{
            $project->delete();
            return response()->json([],204);
        }
        
    }

    public function getProjects(Request $request)
    {
        $projects = Project::whereCondominiumId($request->condominium_id)->get();

        $response=[];
        foreach ($projects as $project) {
            $response[] = [
                'id' => $project->id,
                'condominium_id' => $project->condominium_id,
                'file_id' => $project->file_id,
                'name' => $project->name,
                'created_at' => $project->created_at,
                'updated_at' => $project->updated_at,
                'file_name' => $project->file? $project->file->file:null
            ];
        }

        return $response;
    }

    public function uploadFiles(Request $request){

        
        if ($request->hasFile('file')) {
         
            $create_file = File::createFile($request,'Projects',null);

            $request->request->add(['file_id'=> $create_file['file_id']]);

            $atrributes = request()->validate([
                'condominium_id' => 'required',
                'name' => 'required',
                'file_id' => 'required'
            ]);

            Project::create($atrributes);
            
            return response()->json(['url' => $create_file['file_url']],200);

        } else {
            $file_error = ['file' => ['Arquivo obrigatorio']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $file_error],422);
        }      

    }

    public function downloadFile($id)
    {
        return File::downloadFile($id);
    }

    public function deleteFile(Request $request)
    {
        $project = Project::find($request->project_id);

        if ($project) {
            
            $file = File::find($project->file_id);
    
            if ($file) {
                        
                $project->file_id = null;
                $project->save();
            
                return File::deleteFile($file);

            }else {
                $file_error = ['file' => ['file_id nao localizado']];
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $file_error],422);
            }

        }else{
            $file_error = ['file' => ['O project_id: '.$request->project_id.' nao localizado']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $file_error],422);
        } 
    }

    public function updateFile(Request $request, $project_id)
    {

        $project = Project::find($project_id);

        if ($request->hasFile('file')) {
            
            $file_to_remove = $project->file_id;
            
            $create_file = File::createFile($request,'Projects',null);

            $project->name = $request->name;
            $project->file_id = $file->id;
            $project->save();
            $project->refresh();

            $file = File::find($file_to_remove);
            
            if ($file) {    
                $response_delete = File::deleteFile($file);
            }

            return $project;

        }else{
            
            $project = Project::find($project_id);
            $project->name = $request->name;
            $project->save();
            $project->refresh();

            return $project;
        }
    }

}
