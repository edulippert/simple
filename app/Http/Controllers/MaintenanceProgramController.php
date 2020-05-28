<?php

namespace App\Http\Controllers;

use App\Events\MaintenanceProgramUpdatedEvent;
use App\File;
use App\MaintenanceProgram;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MaintenanceProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
     * @param  \App\MaintenanceProgram  $maintenanceProgram
     * @return \Illuminate\Http\Response
     */
    public function show(MaintenanceProgram $maintenanceprogram)
    {
        if ($maintenanceprogram->customer_guarantee_maintenance->first()){
         
            $maintenance_program = $maintenanceprogram;
            $file = $maintenance_program->file;
            $customer_guarantee_maintenace = $maintenance_program->customer_guarantee_maintenance;
            $customer_guarantee=$maintenance_program->customer_guarantee_maintenance->customer_guarantee;
            
            if ($customer_guarantee) {
                
                $item = $maintenance_program->customer_guarantee_maintenance->customer_guarantee->item;
            }

            
        
        }
            $response = [
                'guarantee_item' => $customer_guarantee ? $item->description:'Nao possui garantia',
                'guarantee_coverage' => $customer_guarantee ? $customer_guarantee->coverage : 'Sem Cobertura',
                'id' => $maintenance_program->id,
                'maintenance_day' => $maintenance_program->maintenance_day,
                'executed_day' => $maintenance_program->executed_day,
                'estimated_cost' => $maintenance_program->estimated_cost,
                'executed_cost' => $maintenance_program->executed_cost,
                'condominium_comments' => $maintenance_program->condominium_comments,
                'company_comments' => $maintenance_program->company_comments,
                'responsible' => $maintenance_program->responsible,
                'file_name' => $file ? $file->file : null,
                'file_id' => $file ? $file->id : null,
                'is_done' => $maintenance_program->is_done,
                'is_editable' => $maintenance_program->maintenance_day < Carbon::now() ? false : true
            ];

        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaintenanceProgram  $maintenanceProgram
     * @return \Illuminate\Http\Response
     */
    public function edit(MaintenanceProgram $maintenanceProgram)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaintenanceProgram  $maintenanceProgram
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaintenanceProgram $maintenanceProgram)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaintenanceProgram  $maintenanceProgram
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaintenanceProgram $maintenanceProgram)
    {
        //
    }

    public function getMaintenancePrograms(Request $request){
       return MaintenanceProgram::getMaintenancesPrograms($request->condominium_id);
       
    }

    public function getMaintenanceProgramsMonthGrouped(Request $request)
    {
       // dd($request);
        return MaintenanceProgram::buildMaintenanceResponse($request->condominium_id);
    }

    public function unblock(Request $request)
    {
        $maintenance_program = MaintenanceProgram::whereId($request->maintenance_program_id)->first();
        if ($maintenance_program) {
            
            $maintenance_program->is_blocked = $request->is_blocked;
            $maintenance_program->save();
            $maintenance_program->refresh();
            return $maintenance_program;

        }else{
            return response()->json(['errors'=>'Manutencao nao localizada '.serialize($request->all()).' nr'],422);
        }
    }

    public function updateMaintenanceProgram(Request $request)
    {
      
        if ($request->is_user=="true") {

            if ($request->hasFile('file')) {
        
                $create_file = File::createFile($request,'ProgramMaintenances',null);

                $maintenance_program = MaintenanceProgram::whereId($request->maintenance_program_id)->first();
                $maintenance_program->condominium_comments = $request->condominium_comments;
                $maintenance_program->estimated_cost = $request->estimated_cost;
                $maintenance_program->executed_cost = $request->executed_cost;
                $maintenance_program->file_id = $create_file['file_id'];
                $maintenance_program->executed_day = Carbon::now();
                $maintenance_program->is_done = true;
                $maintenance_program->responsible = $request->responsible;
                $maintenance_program->save();
                $maintenance_program->refresh();
               
                MaintenanceProgram::where('customer_guarantee_maintenance_id',$maintenance_program->customer_guarantee_maintenance_id)
                ->where('is_done',false)
                ->update(['estimated_cost' => $maintenance_program->estimated_cost]);

                if (MaintenanceProgram::need_to_call_event($maintenance_program->customer_guarantee_maintenance_id,$maintenance_program->maintenance_day)) {
                    event(new MaintenanceProgramUpdatedEvent($maintenance_program));
                }
                
                return $maintenance_program; 
            }else{
                $maintenance_program = MaintenanceProgram::whereId($request->maintenance_program_id)->first();
                
                $maintenance_program->condominium_comments = $request->condominium_comments;
                $maintenance_program->estimated_cost = $request->estimated_cost;
                $maintenance_program->save();
                $maintenance_program->refresh();

                MaintenanceProgram::where('customer_guarantee_maintenance_id',$maintenance_program->customer_guarantee_maintenance_id)
                                        ->where('is_done',false)
                                        ->update(['estimated_cost' => $maintenance_program->estimated_cost]);

                return $maintenance_program; 
            }

            
        }else{
            $maintenance_program = MaintenanceProgram::whereId($request->maintenance_program_id)->first();
            if ($maintenance_program) {
                
                $maintenance_program->company_comments = $request->company_comments;
                $maintenance_program->save();
                $maintenance_program->refresh();
                return $maintenance_program;

            }else{
                return response()->json(['errors'=>'Manutencao nao localizada'.serialize($request->all()).'nr'],422);
            }
        }
    }

    public function downloadFile($id)
    {
        return File::downloadFile($id);
    }

    public function deleteFile(Request $request)
    {

        $maintenance_program = MaintenanceProgram::find($request->maintenance_program_id);

        if ($maintenance_program) {
            
            $file = File::find($request->file_id);
            
            if ($file) {
                   
                $maintenance_program->executed_day = null;
                $maintenance_program->is_done = false;
                $maintenance_program->file_id = null;
                $maintenance_program->save();
                
                return File::deleteFile($file);

            }else{
                $file_error = ['file' => ['O file_id: '.$request->maintenance_program_id.' nao foi localizado']];
                return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $file_error],422);
            }
        }else{
            $file_error = ['file' => ['O maintenance_program_id: '.$request->maintenance_program_id.' nao foi localizado']];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $file_error],422);
        }

    }
}
