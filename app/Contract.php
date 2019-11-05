<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
 
    protected $fillable = [
        'condominium_id',
        'file_id',
        'name',
        'description',
        'total_cost',
        'start_date',
        'end_date',
        'contact_name',
        'contact_email',
        'contact_phone_number'
    ];

    protected $table = 'contracts';

    public static function buildContractsReponse($condominium_id)
    {

        $contracts = self::whereCondominiumId($condominium_id)->get();

        $response= [];

        foreach ($contracts as $contract) {
            # code...
            if ($contract->end_date < Carbon::now()) {
                $situation = 'Expirado';
            }else{
                $situation = 'Ativo';
            }

            $response[] = [
                'condominium_id' => $contract->condominium_id,
                'file_id'=> $contract->file_id,
                'file_name' => $contract->file? $contract->file->file:null,
                'name' => $contract->name,
                'description' => $contract->description,
                'total_cost' => $contract->total_cost,
                'start_date' => $contract->start_date,
                'end_date' => $contract->end_date,
                'contact_name' => $contract->contact_name,
                'contact_email'=> $contract->contact_email,
                'contact_phone_number' => $contract->contact_phone_number,
                'situation' => $situation
            ];


        }

        return $response;       
    }
}
