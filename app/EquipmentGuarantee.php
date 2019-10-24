<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EquipmentGuarantee extends Model
{

    protected $fillable = [
        'condominium_id',
        'file_id',
        'item',
        'start_date',
        'duration',
        'period',
        'total_cost',
        'reference',
        'comments',
        'company',
        'company_number_id',
        'phone',
        'email'
    ];

    protected $table = 'equipment_guarantees';

    public static function buildEpuipmenteGuaranteeResponse($condominium_id)
    {
        $equipment_guarantees = self::whereCondominiumId($condominium_id)->get();

        $response=[];

        foreach ($equipment_guarantees as $equipment_guarantee) {

            //dd($equipment_guarantee);
            $start_date = date('Y-m-d', strtotime($equipment_guarantee->start_date));
            
            // Se for Ano
            if ($equipment_guarantee->period == "1") {
                        
                $due_date = Carbon::createFromFormat('Y-m-d', $start_date )->addYear($equipment_guarantee->duration);
                
            }
            // Se for Mes
            if ($equipment_guarantee->period == "2") {
                    
                $due_date = Carbon::createFromFormat('Y-m-d', $start_date )->addMonth($equipment_guarantee->duration);
                
            }


            if ($due_date < Carbon::now()) {
                $situation = 'Expirado';
            }else{
                $situation = 'Ativo';
            }

             $response[] = [
                 'condominium_id' => $equipment_guarantee->condominium_id,
                 'file_id' => $equipment_guarantee->file_id,
                 'item' => $equipment_guarantee->item,
                 'start_date' => $equipment_guarantee->start_date,
                 'duration' => $equipment_guarantee->duration,
                 'period' => $equipment_guarantee->period,
                 'total_cost' => $equipment_guarantee->total_cost,
                 'reference' => $equipment_guarantee->reference,
                 'comments' => $equipment_guarantee->comments,
                 'company' => $equipment_guarantee->company,
                 'company_number_id' => $equipment_guarantee->company_number_id,
                 'phone' => $equipment_guarantee->phone,
                 'email' => $equipment_guarantee->email,
                 'situation' => $situation
             ];

        }
                        
        return $response;
    }
}
