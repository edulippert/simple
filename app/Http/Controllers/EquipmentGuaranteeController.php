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
        $attributes = request()->validate([
            'condominium_id' => 'required',
            'item' => 'required',
            'start_date'=> '',
            'duration'=> '',
            'period'=> '',
            'total_cost'=> 'required',
            'reference'=> '',
            'comments' => '',
            'company' => '',
            'company_number_id' => '',
            'phone' => '',
            'email' => ''
        ]);

        $equipment_guarantee = EquipmentGuarantee::create($attributes);
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
        $file = $equipmentguarantee->file;
        return [
            'id' => $equipmentguarantee->id,
            'condominium_id' => $equipmentguarantee->condominium_id,
            'file_id' => $equipmentguarantee->file_id,
            'file_name' => $file ? $file->file : null,
            'item' => $equipmentguarantee->item,
            'start_date' => date('Y-m-d', strtotime($equipmentguarantee->start_date)),
            'duration' => $equipmentguarantee->duration,
            'period' => $equipmentguarantee->period,
            'total_cost' => $equipmentguarantee->total_cost,
            'reference' => $equipmentguarantee->reference,
            'comments' => $equipmentguarantee->comments,
            'company' => $equipmentguarantee->company,
            'company_number_id' => $equipmentguarantee->company_number_id,
            'phone' => $equipmentguarantee->phone,
            'email' => $equipmentguarantee->email,
        ];
        //return $equipmentguarantee;
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
        $attributes = request()->validate([
            'condominium_id' => 'required',
            'item' => 'required',
            'start_date'=> '',
            'duration'=> '',
            'period'=> '',
            'total_cost'=> 'required',
            'reference'=> '',
            'comments' => '',
            'company' => '',
            'company_number_id' => '',
            'phone' => '',
            'email' => ''
        ]);

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

        //$equipment_guarantees = EquipmentGuarantee::whereCondominiumId($request->condominium_id)->get();

        $equipment_guarantees = EquipmentGuarantee::buildEpuipmenteGuaranteeResponse($request->condominium_id);

        return $equipment_guarantees;

    }

    public function uploadFiles(Request $request, $id ){

        if ($request->hasFile('file')) {
            
            $create_file = File::createFile($request,'EquipmentGuarantees',null);

            $equipmentGuarantee = EquipmentGuarantee::find($id);
            $equipmentGuarantee->file_id = $create_file['file_id'];
            $equipmentGuarantee->save();

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
}
