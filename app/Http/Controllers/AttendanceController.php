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
    public function update(AttendanceRequest $request, Attendance $attendance)
    {
        $attendance->fill($request->all());
        $attendance->save();
        return $attendance;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return response()->json([],204);
    }

    public function getAttendances(Request $request)
    {
        $attendances = Attendance::whereCompanyId($request->company_id)
                                ->whereCondominiumId($request->condominium_id)
                                ->get();
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
                'file' => 'Attendance',
                'name' => $request->file('file')->getClientOriginalName(),
                'type' => $request->file('file')->getClientOriginalExtension(),
            ]);

            $file->refresh();

            $fileName = $file->name;
            $attendance_path = '/attendances'.'/'.$id;
                 
            $path = $request->file('file')->move(public_path($attendance_path),$fileName);
            
            $fileUrl = url('/attendance'.'/'.$id.'/'.$fileName);
            
            $attendance = Attendance::find($id);
            $attendance->file_id = $file->id;
            $attendance->save();

            return response()->json(['url' => $fileUrl],200);

        } else {
            return 'no file!';
        }
        

    }
}
