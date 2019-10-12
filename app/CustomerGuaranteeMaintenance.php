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


    public static function getGuaranteeMaintenaces($id)
    {
        $allocateds_guatantees_maintenances = self::where('customer_guarantee_id',$id)
                                    ->join('groups','groups.id','group_id')
                                    ->join('items','items.id','item_id')
                                    ->select(
                                        'customer_guarantee_maintenances.id',
                                        'customer_guarantee_maintenances.condominium_id',
                                        'customer_guarantee_id',
                                        'customer_guarantee_maintenances.group_id',
                                        'groups.description as group_description',
                                        'customer_guarantee_maintenances.item_id',
                                        'items.description as item_description',
                                        'customer_guarantee_maintenances.activity',
                                        'customer_guarantee_maintenances.description',
                                        'customer_guarantee_maintenances.amount',
                                        'customer_guarantee_maintenances.period',
                                        'customer_guarantee_maintenances.responsable',
                                        'customer_guarantee_maintenances.font'
                                    )
                                    ->get();

        return $allocateds_guatantees_maintenances;
    }

    public static function getJustMaintenances($condominium_id)
    {
        $allocateds_maintenances = self::where('condominium_id',$condominium_id)
                                    ->where('customer_guarantee_id',null)
                                    ->join('groups','groups.id','group_id')
                                    ->join('items','items.id','item_id')
                                    ->select(
                                        'customer_guarantee_maintenances.id',
                                        'customer_guarantee_maintenances.condominium_id',
                                        'customer_guarantee_id',
                                        'customer_guarantee_maintenances.group_id',
                                        'groups.description as group_description',
                                        'customer_guarantee_maintenances.item_id',
                                        'items.description as item_description',
                                        'customer_guarantee_maintenances.activity',
                                        'customer_guarantee_maintenances.description',
                                        'customer_guarantee_maintenances.amount',
                                        'customer_guarantee_maintenances.period',
                                        'customer_guarantee_maintenances.responsable',
                                        'customer_guarantee_maintenances.font'
                                    )
                                    ->get();

        return $allocateds_maintenances;
    }


}
