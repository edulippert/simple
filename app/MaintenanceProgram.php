<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaintenanceProgram extends Model
{
    protected $fillable = [
                            'customer_guarantee_maintenance_id',
                            'file_id',
                            'maintenance_day',
                            'executed_day',
                            'status',
                            'is_done',
                            'is_blocked'
                        ];

    protected $table = 'maintenance_programs';

    protected $guarded = ['id'];

    function customer_guarantee_maintenance()
    {
        return $this->belongsTo(CustomerGuaranteeMaintenance::class, 'customer_guarantee_maintenance_id' , 'id');
    }
    
}
