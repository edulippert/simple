<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\File;
use App\Http\Requests\AttendanceRequest;
use Illuminate\Http\Request;

class AttendanceController extends Controller
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
    public function store(AttendanceRequest $request)
    {
        $attendance = Attendance::create($request->all());
        return $attendance;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        return $attendance;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {   
        if ($request->is_finalized == "true"){

            $attributes = request()->validate([
                'attendance_place' => 'required',
                'call_date' => 'required',
                'inspection_date' => 'required',
                'finish_date' => 'required',
                'description' => 'required',
                'solution' => 'required',
                'responsible'=> 'required',
                'manpower_cost'=> 'required',
                'material_cost'=> 'required',
                'total_cost'=> 'required',
                'contact_name'=> 'required',
                'contact_email'=> 'required',
                'contact_phone_number'=> 'required',
                'condominium_id' => 'required',
                'is_finalized' => ''
               // 'company_id' => 'required'
            ]);

            $attendance->fill($attributes);
            $attendance->save();
            return $attendance;
        }else{
            $attributes = request()->validate([
                'attendance_place' => 'required',
                'call_date' => 'required',
                'inspection_date' => '',
                'finish_date' => '',
                'description' => 'required',
                'solution' => '',
                'responsible'=> '',
                'manpower_cost'=> '',
                'material_cost'=> '',
                'total_cost'=> '',
                'contact_name'=> 'required',
                'contact_email'=> '',
                'contact_phone_number'=> 'required',
                'condominium_id' => '',
                'is_finalized' => ''
            ]);

            $attendance->fill($attributes);
            $attendance->save();
            return $attendance;
        }
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        if ($attendance->file){
            $file = $attendance->file;
            $name = $file->name;
            $licensePath = '/attendances'.'/'.$file->id;
            $completePath = $licensePath;

            
            \File::deleteDirectory(\public_path($completePath));

            $attendance->delete();
            $file->delete();

            return response()->json([],204);
        }else{
            $attendance->delete();
            return response()->json([],204);
        }
    }

    public function getAttendances(Request $request)
    {
        $attendances = Attendance::whereCondominiumId($request->condominium_id)->get();
        return $attendances;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function uploadoFiles(Request $request, $id ){

        if ($request->hasFile('file')) {
            
           
            $file = File::create([
                'file' => $request->file('file')->getClientOriginalName(),
                'name' => $request->file('file')->hashName(),
                'type' => $request->file('file')->getClientOriginalExtension(),
                'subtype' => 'Attendance'
            ]);


            $file->refresh();

            $fileName = $file->name;
            $attendance_path = '/attendances'.'/'.$file->id;
                 
            $path = $request->file('file')->move(public_path($attendance_path),$fileName);
            
            $fileUrl = url('/attendances'.'/'.$file->id.'/'.$fileName);
            
            $attendance = Attendance::find($id);
            $attendance->file_id = $file->id;
            $attendance->save();

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
            $attendance_path = '/attendances'.'/'.$file->id.'/';
            $completePath = $attendance_path.$name;
        }
        
        return response()->download(\public_path($completePath),$file->file);
    }

    public function acceptanceTerm($id)
    {
        $attendance = Attendance::getAcceptanceTerm($id);
        return $attendance;

    }
}
