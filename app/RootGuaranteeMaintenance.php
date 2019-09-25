<?php

namespace App;

use App\Group;
use Illuminate\Database\Eloquent\Model;

class RootGuaranteeMaintenance extends Model
{
    protected $fillable = [ 'root_guarantee_id',
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

    protected $table = 'root_guarantee_maintenances';

    public static function buildRootGuaranteeMaintenancesResponse($root_guarantee_id)
    {
        
        $guarantee_maintenances = self::getRootGuaranteeMaintenance($root_guarantee_id);

        $groups = Group::getDistinctGroups($guarantee_maintenances);

        $response = [];

        foreach ($groups as $group) {
            $grouped_guarantee_maintenances = $guarantee_maintenances->where('group_id',$group['group_id']);
            
            $response[] = [
                'group_id' => $group['group_id'],
                'description' => $group['group_description'],
                'collapse' => true,
                'items' => self::getGroupedItems($grouped_guarantee_maintenances)
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
                'root_guarantee_id' => $item['id'],
                'item_id' => $item['item_id'],
                'item_description' => $item['item_description'],
                'maintenances_description' => $item['maintenances_description'],
                'amount' => $item['amount'],
                'period' => $item['period'],
                'responsable' => $item['responsable'],
                'font' => $item['font']
            ];

        }

        return $response;

    }
    
    public static function getRootGuaranteeMaintenance($root_guarantee_id)
    {

        $guarantee_maintenances = self::where('root_guarantee_id',$root_guarantee_id)
                                    ->join('groups','groups.id','root_guarantee_maintenances.group_id')
                                    ->join('items','items.id','root_guarantee_maintenances.item_id')
                                    ->join('root_guarantees','root_guarantees.id','root_guarantee_maintenances.root_guarantee_id')
                                    ->select('root_guarantee_maintenances.id',
                                            'root_guarantee_maintenances.root_guarantee_id',
                                            'groups.id as group_id',
                                            'groups.description as group_description',
                                            'items.id as item_id',
                                            'items.description as item_description',
                                            'root_guarantee_maintenances.description as maintenances_description',
                                            'root_guarantee_maintenances.amount',
                                            'root_guarantee_maintenances.period',
                                            'root_guarantee_maintenances.responsable',
                                            'root_guarantee_maintenances.font'
                                            )
                                    ->get();
        
        return $guarantee_maintenances;
    }

}
