<?php

namespace App;

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
}
