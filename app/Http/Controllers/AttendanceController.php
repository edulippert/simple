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
        
        $response = [];

        foreach ($attendances as $attendance) {
            $response[] = [
                'id' => $attendance->id,
                'company_id' => $attendance->company_id,
                'file_id'=> $attendance->file_id,
                'attendance_place'=> $attendance->attendance_place,
                'call_date'=>date('Y-m-d', strtotime($attendance->call_date)),
                'inspection_date'=> date('Y-m-d', strtotime($attendance->inspection_date)),
                'finish_date'=> date('Y-m-d', strtotime($attendance->finish_date)),
                'description'=> $attendance->description,
                'solution'=> $attendance->solution,
                'responsible'=> $attendance->responsible,
                'manpower_cost'=> $attendance->manpower_cost,
                'material_cost'=> $attendance->material_cost,
                'total_cost'=> $attendance->total_cost,
                'contact_name'=> $attendance->contact_name,
                'contact_email'=> $attendance->contact_email,
                'contact_phone_number'=> $attendance->contact_phone_number,
                'condominium_id'=> $attendance->condominium_id,
                'is_finalized'=> $attendance->is_finalized
            ];
        }

        return $response;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function uploadoFiles(Request $request, $id ){

        if ($request->hasFile('file')) {
            
            $create_file = File::createFile($request,'Attendances',null);
            
            $attendance = Attendance::find($id);
            $attendance->file_id = $create_file['file_id'];
            $attendance->save();

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

    public function acceptanceTerm($id)
    {
        $attendance = Attendance::getAcceptanceTerm($id);
        return $attendance;

    }
}
