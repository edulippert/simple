<?php

namespace App\Http\Controllers;

use App\File;
use App\EquipmentGuarantee;
use Illuminate\Http\Request;

class EquipmentGuaranteeController extends Controller
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
        $equipment_guarantee = EquipmentGuarantee::create($request->all());
        return $equipment_guarantee; 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EquipmentGuarantee  $equipmentGuarantee
     * @return \Illuminate\Http\Response
     */
    public function show(EquipmentGuarantee $equipmentguarantee)
    {
        return $equipmentguarantee;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EquipmentGuarantee  $equipmentGuarantee
     * @return \Illuminate\Http\Response
     */
    public function edit(EquipmentGuarantee $equipmentGuarantee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EquipmentGuarantee  $equipmentGuarantee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EquipmentGuarantee $equipmentguarantee)
    {
        $equipmentguarantee->fill($request->all());
        $equipmentguarantee->save();
        return $equipmentguarantee;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EquipmentGuarantee  $equipmentGuarantee
     * @return \Illuminate\Http\Response
     */
    public function destroy(EquipmentGuarantee $equipmentguarantee)
    {
        $equipmentguarantee->delete();
    }

    public function getEquipmenteGuarantees(Request $request)
    {

        $equipment_guarantees = EquipmentGuarantee::whereCondominiumId($request->condominium_id)->get();
        return $equipment_guarantees;

    }

    public function uploadoFiles(Request $request, $id ){

        if ($request->hasFile('file')) {
            
            $file = File::create([
                'file' => $request->file('file')->getClientOriginalName(),
                'name' => $request->file('file')->hashName(),
                'type' => $request->file('file')->getClientOriginalExtension(),
                'subtype' => 'EquipmentGuarantee'
            ]);

            $file->refresh();

            $fileName = $file->name;
            $equipment_path = '/equipment_guarantees'.'/'.$file->id;
                 
            $path = $request->file('file')->move(public_path($equipment_path),$fileName);
            
            $fileUrl = url('/equipment_guarantees'.'/'.$file->id.'/'.$fileName);
            
            $attendance = EquipmentGuarantee::find($id);
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
            $equipment_path = '/equipment_guarantees'.'/'.$file->id.'/';
            $completePath = $equipment_path.$name;
        }

        return response()->download(\public_path($completePath),$file->file);
    }
}
