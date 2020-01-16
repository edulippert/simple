<?php

namespace App\Http\Controllers;

use App\Guarantee;
use Carbon\Carbon;
use App\Condominium;
use App\CustomerGuarantee;
use App\Maintenance;
use App\CustomerGuaranteeMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\MaintenanceProgram;
use PhpParser\PrettyPrinter\Standard;

class AllocateGuaranteesAndMaintenances extends Controller
{
    
    /** 
         * allocate => 1 or 2
    **/
    public function allocates(Request $request)
    {
        if ($request->allocate == 1) {
            
            $response = Guarantee::all();

        }else {
            $response = Maintenance::all();
        }

        return $response;
    }

    /** 
         * guarantee_id => required
         * condominium_id => required
         * root_guarantee_id => optional null when blank
    **/
    public function allocateGuaranteesAndMaintenances(Request $request)
    {
        //Garantias e Manutencoes
        if ($request->allocate == 1) {
                # code...
           
            $condominium = Condominium::find($request->condominium_id);
        
            $start_date = date('Y-m-d', strtotime($condominium->licence_due_date));
            
        
            if (!$start_date){
                return response()->json(['errors'=>'Favor definir a data de habite-se antes de distribuir as Garantias e Manutencoes'],422);
            }

            $guarantee = Guarantee::find($request->standard_id);

            if ($request->root_standard_id != null) {
                $root_guarantees = $guarantee->rootGuarantees->where('id',$request->root_standard_id);
            }else{
                $root_guarantees = $guarantee->rootGuarantees;
            }
          
            foreach ($root_guarantees as $root_guarantee) {

                // Se for Ano
                if ($root_guarantee->period === "4") {
                        
                    $due_date = Carbon::createFromFormat('Y-m-d', $start_date )->addYear($root_guarantee->amount);
                    $period = 'Anos';
                }
                // Se for Mes
                if ($root_guarantee->period === "3") {
                        
                    $due_date = Carbon::createFromFormat('Y-m-d', $start_date )->addMonth($root_guarantee->amount);
                    $period = 'Meses';      
                }
                // Se for Semanas
                if ($root_guarantee->period === "2") {
                        
                    $due_date = Carbon::createFromFormat('Y-m-d', $start_date )->addWeek($root_guarantee->amount);
                    $period = 'Semanas';      
                }
                // Se for Dias
                if ($root_guarantee->period === "1") {
                        
                    $due_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($root_guarantee->amount);
                    $period = 'Dias';      
                }

                if ($root_guarantee->period === "0") {
                        
                    $due_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay(0);
                    $period = 'Na Entrega';      
                }

                // if ($due_date > Carbon::now()) {
                //     $status = 'Ativa';
                // }else{
                //     $status = 'Expirada';
                // }
                
                $request_customer_guarantee = ['condominium_id' => $request->condominium_id,
                                            'group_id' => $root_guarantee->group_id,
                                            'item_id' => $root_guarantee->item_id,
                                            'start_date' => $start_date,
                                            'amount' => $root_guarantee->amount,
                                            'period' => $period,
                                            'due_date' => $due_date,
                                            'is_active' => true,
                                            'is_expired' => true,
                                            'reference' => $root_guarantee->reference,
                                            'coverage' => $root_guarantee->description,
                                            'status' => ''
                                            ];

                $valid_customer_guarantee_request = Validator::make($request_customer_guarantee,[
                    'item_id' => ['required',
                        Rule::unique('customer_guarantees')->where(function ($query) use ($request_customer_guarantee){
                            return $query
                                ->whereGroupId($request_customer_guarantee['group_id'])
                                ->whereItemId($request_customer_guarantee['item_id'])
                                ->whereCondominiumId($request_customer_guarantee['condominium_id'])
                                ->whereCoverage($request_customer_guarantee['coverage']);
                        }),
                    ]
                ]);
                
                if ($valid_customer_guarantee_request->fails()){
                    $file_error = ['file' => ['Essa Garantia: '.$request_customer_guarantee['item_id'].' ja foi atribuida para esse Condominio']];
                    return response()->json([
                        'message' => 'The given data was invalid.',
                        'errors' => $file_error],422);
                    //return response()->json(['errors'=>''],422); 
                }

                $customer_guarantees = CustomerGuarantee::create($request_customer_guarantee);

                $customer_guarantees->refresh();
                
                $root_guarantee_maintenances = $root_guarantee->root_guarantee_maintenaces;

                if ($root_guarantee_maintenances->first()) {
                    
                    foreach ($root_guarantee_maintenances as $root_guarantee_maintenance) {
                        
                        $customer_guarantee_maintenance =  CustomerGuaranteeMaintenance::create([
                            'condominium_id' => $request->condominium_id,
                            'customer_guarantee_id' => $customer_guarantees->id,
                            'group_id' => $root_guarantee_maintenance->group_id,
                            'item_id' => $root_guarantee_maintenance->item_id,
                            'subitem_id' => $root_guarantee_maintenance->subitem_id,
                            'activity' => $root_guarantee_maintenance->activity,
                            'description' => $root_guarantee_maintenance->description,
                            'amount' => $root_guarantee_maintenance->amount,
                            'period' => $root_guarantee_maintenance->period,
                            'responsable' => $root_guarantee_maintenance->responsable,
                            'font' => $root_guarantee_maintenance->font,
                            'optional_period' => $root_guarantee_maintenance->optional_period,
                            'is_informed' => $root_guarantee_maintenance->is_informed
                        ]);

                        $customer_guarantee_maintenance->refresh();

                        
                        if ( $customer_guarantee_maintenance->period == "2" ) {
                            $days_to_next_maintenance = (int)(365/$customer_guarantee_maintenance->amount);
                            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
                        }elseif ($customer_guarantee_maintenance->period == "1") {
                            $days_to_next_maintenance = (int)(30/$customer_guarantee_maintenance->amount);
                            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
                        }elseif ($customer_guarantee_maintenance->period == "3") {
                            $days_to_next_maintenance = (int)($customer_guarantee_maintenance->amount);
                            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
                        }elseif ($customer_guarantee_maintenance->period == "4") {
                            $days_to_next_maintenance = (int)(7*$customer_guarantee_maintenance->amount);
                            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
                        }elseif ($customer_guarantee_maintenance->period == "5") {
                            $days_to_next_maintenance = (int)(30*$customer_guarantee_maintenance->amount);
                            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
                        }elseif ($customer_guarantee_maintenance->period == "6") {
                            $days_to_next_maintenance = (int)(365*$customer_guarantee_maintenance->amount);
                            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
                        }


                        $maintenance_program = MaintenanceProgram::create([
                            'customer_guarantee_maintenance_id' => $customer_guarantee_maintenance->id,
                            'maintenance_day' => $maintenance_date,
                            'is_blocked' => true
                        ]);

                    }

                }

            }

            return response()->json(['message'=>'Garantias e Manutencoes Distribiudas com sucesso'],200);
        }

        if ($request->allocate == 2) {

            $condominium = Condominium::find($request->condominium_id);
        
            $start_date = date('Y-m-d', strtotime($condominium->licence_due_date));
            
        
            if (!$start_date){
                return response()->json(['errors'=>'Favor definir a data de habite-se antes de distribuir as Garantias e Manutencoes'],422);
            }

            $maintenance = Maintenance::find($request->standard_id);

            if (!$maintenance) {
                return response()->json(['errors'=>'Manutencao Padrao nao localizada'],422);
            }

            if ($request->root_standard_id != null) {
                $root_maintenances = $maintenance->rootMaintenances->where('id',$request->root_standard_id);
            }else{
                $root_maintenances = $maintenance->rootMaintenances;
            }

            foreach ($root_maintenances as $root_maintenance) {
                
                $request_guarantee_maintenance = [
                    'condominium_id' => $request->condominium_id,
                    'group_id' => $root_maintenance->group_id,
                    'item_id' => $root_maintenance->item_id,
                    'subitem_id' => $root_maintenance->subitem_id,
                    'activity' => $root_maintenance->activity,
                    'description' => $root_maintenance->description,
                    'amount' => $root_maintenance->amount,
                    'period' => $root_maintenance->period,
                    'responsable' => $root_maintenance->responsable,
                    'font' => $root_maintenance->font,
                    'optional_period' => $root_maintenance->optional_period,
                    'is_informed' => $root_maintenance->is_informed
                ];
                
                $valid_customer_maintenanace_request = Validator::make($request_guarantee_maintenance,[
                    'item_id' => ['required',
                        Rule::unique('customer_guarantee_maintenances')->where(function ($query) use ($request_guarantee_maintenance){
                            return $query
                                ->whereGroupId($request_guarantee_maintenance['group_id'])
                                ->whereItemId($request_guarantee_maintenance['item_id'])
                                ->whereActivity($request_guarantee_maintenance['activity'])
                                ->whereCondominiumId($request_guarantee_maintenance['condominium_id']);
                        }),
                    ]
                ]);

                if ($valid_customer_maintenanace_request->fails()){
                    $file_error = ['file' => ['Essa Manutencao: '.$request_guarantee_maintenance['item_id'].' ja foi atribuida para esse Condominio']];
                    return response()->json([
                        'message' => 'The given data was invalid.',
                        'errors' => $file_error],422);
                }

                $customer_guarantee_maintenance =  CustomerGuaranteeMaintenance::create($request_guarantee_maintenance);
                
                $customer_guarantee_maintenance->refresh();

                        
                if ( $customer_guarantee_maintenance->period == "2" ) {
                    $days_to_next_maintenance = (int)(365/$customer_guarantee_maintenance->amount);
                    $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
                }elseif ($customer_guarantee_maintenance->period == "1") {
                    $days_to_next_maintenance = (int)(30/$customer_guarantee_maintenance->amount);
                    $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
                }elseif ($customer_guarantee_maintenance->period == "3") {
                    $days_to_next_maintenance = (int)($customer_guarantee_maintenance->amount);
                    $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
                }elseif ($customer_guarantee_maintenance->period == "4") {
                    $days_to_next_maintenance = (int)(7*$customer_guarantee_maintenance->amount);
                    $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
                }elseif ($customer_guarantee_maintenance->period == "5") {
                    $days_to_next_maintenance = (int)(30*$customer_guarantee_maintenance->amount);
                    $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
                }elseif ($customer_guarantee_maintenance->period == "6") {
                    $days_to_next_maintenance = (int)(365*$customer_guarantee_maintenance->amount);
                    $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
                }


                $maintenance_program = MaintenanceProgram::create([
                    'customer_guarantee_maintenance_id' => $customer_guarantee_maintenance->id,
                    'maintenance_day' => $maintenance_date,
                    'is_blocked' => true
                ]);

            }
            return response()->json(['message'=>'Manutencoes Distribiudas com sucesso'],200);

        }

    }

    public function allocateJustMaintenances(Request $request)
    {
        

        
        

    }
}
