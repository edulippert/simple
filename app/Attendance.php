<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    
    protected $fillable = [
        'company_id',
        'file_id',
        'attendance_place',
        'call_date',
        'inspection_date',
        'finish_date',
        'description',
        'solution',
        'responsible',
        'manpower_cost',
        'material_cost',
        'total_cost',
        'contact_name',
        'contact_email',
        'contact_phone_number',
        'condominium_id',
        'is_finalized'
    ];

    protected $table = 'attendances';

    

}
