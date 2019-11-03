<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RootMaintenance extends Model
{
    protected $fillable = [ 'maintenance_id',
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

    protected $table = 'root_maintenances';


    public static function buildRootMaintenancesResponse($maintenance_id,$condominium_id=null)
    {
        $root_maintenances = self::getRootMaintenances($maintenance_id);

        $groups = Group::getDistinctGroups($root_maintenances);
        
        $response = [];

        foreach ($groups as $group) {
            
            $grouped_root_maintenances = $root_maintenances->where('group_id',$group['group_id']);
            
            $response[] = [
                'group_id' => $group['group_id'],
                'description' => $group['group_description'],
                'collapse' => true,
                'items' => self::getGroupedItems($grouped_root_maintenances,$condominium_id)
            ];
        }

        return $response;
    }

    public static function getGroupedItems($grouped_items,$condominium_id)
    {
        $response = [];

        foreach ($grouped_items as $item ) {

            if ($condominium_id) {
                
                $response[] = [
                    'id' => $item['id'],
                    'description' => $item['description'],
                    'activity' => $item['activity'],
                    'item_id' => $item['item_id'],
                    'item_description' => $item['item_description'],
                    'amount' => $item['amount'],
                    'period' => $item['period'],
                    'font' => $item['font'],
                    'was_allocated' => self::wasAllocated($condominium_id,$item['group_id'],$item['item_id'],$item['activity'])
                ];

            }else {
                
                $response[] = [
                    'id' => $item['id'],
                    'description' => $item['description'],
                    'activity' => $item['activity'],
                    'item_id' => $item['item_id'],
                    'item_description' => $item['item_description'],
                    'amount' => $item['amount'],
                    'period' => $item['period'],
                    'font' => $item['font']
                ];

            }
            

        }

        return $response;
    }

    public static function wasAllocated($condominium_id,$group_id,$item_id,$activity)
    {
        $customer_guarantee = CustomerGuaranteeMaintenance::where('condominium_id',$condominium_id)
                                            ->where('group_id',$group_id)
                                            ->where('item_id',$item_id)
                                            ->where('activity',$activity)
                                            ->first();
        
        return $customer_guarantee ? true:false;
    }

    public static function getRootMaintenances($maintenance_id)
    {
        $root_maintenances = self::where('maintenance_id',$maintenance_id)
                    ->join('groups','groups.id','root_maintenances.group_id')
                    ->join('items','items.id','root_maintenances.item_id')
                    ->select('root_maintenances.id','root_maintenances.description','root_maintenances.activity',
                            'maintenance_id',
                            'root_maintenances.group_id',
                            'groups.description as group_description',
                            'item_id',
                            'items.description as item_description',
                            'amount',
                            'period',
                            'font')
                    ->distinct()
                    ->get();

        return $root_maintenances;
    }


}
