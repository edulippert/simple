<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
