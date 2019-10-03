<?php

namespace App\Http\Controllers;

use App\Guarantee;
use Carbon\Carbon;
use App\Condominium;
use App\CustomerGuarantee;
use App\CustomerGuaranteeMaintenance;
use Illuminate\Http\Request;

class AllocateGuaranteesAndMaintenances extends Controller
{
    
    /** 
         * guarantee_id => required
         * condominium_id => required
         * root_guarantee_id => optional null when blank
    * */
    public function allocateGuaranteesAndMaintenances(Request $request)
    {

        $condominium = Condominium::find($request->condominium_id);
       
        $start_date = date('Y-m-d', strtotime($condominium->licence_due_date));
        
       
        if (!$start_date){
            return response()->json(['Favor definir a data de habite-se antes de distribuir as Garantias e Manutencoes'],206);
        }

        $guarantee = Guarantee::find($request->guarantee_id);

        $root_guarantees = $guarantee->rootGuarantees;

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
            if ($root_guarantee->period === "2") {
                    
                $due_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($root_guarantee->amount);
                $period = 'Dias';      
            }            

            $customer_guarantees = CustomerGuarantee::create([
                'condominium_id' => $request->condominium_id,
                'group_id' => $root_guarantee->group_id,
                'item_id' => $root_guarantee->item_id,
                'start_date' => $start_date,
                'amount' => $root_guarantee->amount,
                'period' => $period,
                'due_date' => $due_date,
                'is_active' => true,
                'is_expired' => true,
                'reference' => $root_guarantee->reference,
            ]);

            $customer_guarantees->refresh();
            
            $root_guarantee_maintenances = $root_guarantee->root_guarantee_maintenaces;

            if ($root_guarantee_maintenances->first()) {
                
                foreach ($root_guarantee_maintenances as $root_guarantee_maintenance) {
                    
                    $customer_guarantee_maintenance =  CustomerGuaranteeMaintenance::create([
                        'customer_guarantee_id' => $customer_guarantees->id,
                        'group_id' => $root_guarantee_maintenance->group_id,
                        'item_id' => $root_guarantee_maintenance->item_id,
                        'subitem_id' => $root_guarantee_maintenance->subitem_id,
                        'activity' => $root_guarantee_maintenance->activity,
                        'description' => $root_guarantee_maintenance->description,
                        'amount' => $root_guarantee_maintenance->amount,
                        'period' => $root_guarantee_maintenance->period,
                        'responsable' => $root_guarantee_maintenance->responsable,
                        'font' => $root_guarantee_maintenance->font
                    ]);
                }

            }

        }

        return response()->json('Garantias e Manutencoes Distribiudas com sucesso',200);
        

    }

    public function allocateJustMaintenances(Request $request)
    {

    }
}
