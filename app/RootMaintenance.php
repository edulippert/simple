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


    public static function buildRootMaintenancesResponse($maintenance_id)
    {
        $root_maintenances = self::getRootMaintenances($maintenance_id);

        $groups = Group::getDistinctGroups($root_maintenances);
        
        $response = [];

        foreach ($groups as $group) {
            
            $grouped_root_maintenances = $root_maintenances->where('group_id',$group['group_id']);
            
            $response[] = [
                'group_id' => $group['group_id'],
                'description' => $group['group_description'],
                'collapse' => false,
                'items' => self::getGroupedItems($grouped_root_maintenances)
            ];
        }

        return $response;
    }

    public static function getGroupedItems($grouped_items)
    {
        $response = [];

        foreach ($grouped_items as $item ) {
            
            $response[] = [
                'id' => $item['id'],
                'item_id' => $item['item_id'],
                'description' => $item['item_description'],
                'amount' => $item['amount'],
                'period' => $item['period'],
                'font' => $item['font']
            ];

        }

        return $response;
    }

    public static function getRootMaintenances($maintenance_id)
    {
        $root_maintenances = self::where('maintenance_id',$maintenance_id)
                    ->join('groups','groups.id','root_maintenances.group_id')
                    ->join('items','items.id','root_maintenances.item_id')
                    ->select('root_maintenances.id',
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
