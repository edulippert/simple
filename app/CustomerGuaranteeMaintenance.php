<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerGuaranteeMaintenance extends Model
{
    protected $fillable = ['customer_guarantee_id',
                            'condominium_id',
                            'group_id',
                            'item_id',
                            'subitem_id',
                            'activity',
                            'description',
                            'amount',
                            'period',
                            'responsable',
                            'font'
                        ];

    protected $table = 'customer_guarantee_maintenances';

    public function maintenance_programs()
    {
        return $this->hasMany(MaintenanceProgram::class, 'customer_guarantee_maintenance_id', 'id');
    }
}
