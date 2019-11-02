<?php

namespace App;

use App\Group;
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
                            'reference',
                            'description'
                        ];
    
    protected $table = 'root_guarantees';

    public static function buildRootGuaranteesResponse($guarantee_id , $condominium_id=null)
    {

        $root_guarantees = self::getRootGuarantees($guarantee_id);

        $groups = Group::getDistinctGroups($root_guarantees);
        
        $response = [];

        foreach ($groups as $group) {
            
            $grouped_root_guarantees = $root_guarantees->where('group_id',$group['group_id']);
            
            $response[] = [
                'group_id' => $group['group_id'],
                'description' => $group['group_description'],
                'collapse' => true,
                'items' => self::getGroupedItems($grouped_root_guarantees,$condominium_id)
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
                    'item_id' => $item['item_id'],
                    'description' => $item['item_description'],
                    'guarantee_description' =>$item['guarantee_description'],
                    'amount' => $item['amount'],
                    'period' => $item['period'],
                    'reference' => $item['reference'],
                    'has_maintenance' => self::hasGuaranteeMaintenances($item['id']),
                    'was_allocated' => self::wasAllocated($condominium_id,$item['group_id'],$item['item_id'])
                ];
    
            }else{

                $response[] = [
                    'id' => $item['id'],
                    'item_id' => $item['item_id'],
                    'description' => $item['item_description'],
                    'guarantee_description' =>$item['guarantee_description'],
                    'amount' => $item['amount'],
                    'period' => $item['period'],
                    'reference' => $item['reference'],
                    'has_maintenance' => self::hasGuaranteeMaintenances($item['id'])
                ];
            }


        }

        return $response;
    }

    public static function wasAllocated($condominium_id,$group_id,$item_id)
    {
        $customer_guarantee = CustomerGuarantee::where('condominium_id',$condominium_id)
                                            ->where('group_id',$group_id)
                                            ->where('item_id',$item_id)
                                            ->first();
        
        return $customer_guarantee ? true:false;
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
                            'reference',
                            'root_guarantees.description as guarantee_description')
                    ->distinct()
                    ->get();

        return $root_guarantees;
    }

    public static function showRootGuarantee($id)
    {
        $root_guarantees = self::where('root_guarantees.id',$id)
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
                            'reference',
                            'root_guarantees.description')
                    ->distinct()
                    ->first();

        return $root_guarantees;
    }


    public function root_guarantee_maintenaces(){
        return $this->hasMany(RootGuaranteeMaintenance::class,'root_guarantee_id');
    }

    public function guarantees(){
        return $this->belongsTo(Guarantee::class,'guarantee_id','id');
    }

    public function groups(){
        return $this->belongsTo(Group::class,'group_id','id');
    }

    public function item(){
        return $this->belongsTo(Item::class,'item_id','id');
    }
}
