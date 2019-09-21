<?php

namespace App;

use App\RootGuaranteeMaintenance;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class RootGuarantee extends Model
{
    protected $fillable = [ 'guarantee_id',
                            'group_id',
                            'item_id',
                            'subitem_id',
                            'amount',
                            'period',
                            'is_active',
                            'reference'
                        ];
    
    protected $table = 'root_guarantees';

    public static function buildRootGuaranteesResponse($guarantee_id)
    {
        $root_guarantees = self::getRootGuarantees($guarantee_id);

        $groups = self::getDistinctGroupsGarantees($root_guarantees);

        $response = [];

        foreach ($groups as $group) {
            
            $grouped_root_guarantees = $root_guarantees->where('group_id',$group['group_id']);
            
            $response[] = [
                'group_id' => $group['group_id'],
                'description' => $group['group_description'],
                'collapse' => true,
                'items' => self::getGroupedItems($grouped_root_guarantees)
            ];
        }

        return $response;
    }

    public static function getGroupedItems($grouped_items)
    {
        $response = [];

        foreach ($grouped_items as $item ) {
            
            $response[] = [
                'root_guarantee_id' => $item['id'],
                'item_id' => $item['item_id'],
                'description' => $item['item_description'],
                'amount' => $item['amount'],
                'period' => $item['period'],
                'reference' => $item['reference'],
                'has_maintenance' => self::hasGuaranteeMaintenances($item['id'])
            ];

        }

        return $response;
    }

    public static function hasGuaranteeMaintenances($root_guarantee_id)
    {
        $guatantee_maintenance = RootGuaranteeMaintenance::where('root_guarantee_id',$root_guarantee_id)->first();

        return $guatantee_maintenance ? true : false;

    }

    public static function getRootGuarantees($guarantee_id)
    {
        $root_guarantees = self::where('guarantee_id',$guarantee_id)
                    ->join('groups','groups.id','root_guarantees.group_id')
                    ->join('items','items.id','root_guarantees.item_id')
                    ->select('root_guarantees.id',
                            'guarantee_id',
                            'root_guarantees.group_id',
                            'groups.description as group_description',
                            'item_id',
                            'items.description as item_description',
                            'amount',
                            'period',
                            'reference')
                    ->distinct()
                    ->get();

        return $root_guarantees;
    }

    public static function getDistinctGroupsGarantees($root_guarantees)
    {
        $groups = $root_guarantees->map->only(['group_id','group_description']);
        
        $group_collection = new Collection($groups);
        
        $unique_groups = $group_collection->unique();
        
        return $unique_groups;
    }

    public function root_guarantee_maintenaces(){
        return $this->hasMany(RootGuaranteeMaintenance::class);
    }

    public function guarantees(){
        return $this->belongsTo(Guarantee::class);
    }

    public function groups(){
        return $this->belongsTo(Group::class,'group_id','id');
    }
}
