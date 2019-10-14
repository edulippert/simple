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

    public static function getMaintenancesPrograms($condominium_id)
    {
        $maintenance_programs = self::where('customer_guarantee_maintenances.condominium_id',$condominium_id)
                                ->where('is_done',false)
                                ->join('customer_guarantee_maintenances','customer_guarantee_maintenances.id','maintenance_programs.customer_guarantee_maintenance_id')
                                ->join('groups','groups.id','customer_guarantee_maintenances.group_id')
                                ->join('items','items.id','customer_guarantee_maintenances.item_id')
                                ->select(
                                    'maintenance_programs.id',
                                    'customer_guarantee_maintenances.group_id',
                                    'groups.description as group_description',
                                    'customer_guarantee_maintenances.item_id',
                                    'items.description as item_description',
                                    'customer_guarantee_maintenances.activity',
                                    'customer_guarantee_maintenances.description',
                                    'maintenance_day',
                                    'executed_day',
                                    'status',
                                    'is_done',
                                    'is_blocked'
                                )
                                ->orderBy('maintenance_day')
                                ->get();
        
        return $maintenance_programs;

    }

    function customer_guarantee_maintenance()
    {
        return $this->belongsTo(CustomerGuaranteeMaintenance::class, 'customer_guarantee_maintenance_id' , 'id');
    }
    
}
