<?php

namespace App;

use App\FinishGroup;
use Illuminate\Database\Eloquent\Model;

class Finish extends Model
{
    protected $fillable = ['condominium_id','group_id','item_id','description'];

    protected $table = 'finishes';

    
    public static function buildFinishesResponse($condominium_id)
    {

        $finishes = self::getFinishes($condominium_id);

        $groups = FinishGroup::getDistinctGroups($finishes);

        $response = [];

        foreach ($groups as $group) {
            $grouped_finishes = $finishes->where('group_id',$group['group_id']);

            $response[] = [
                'group_id' => $group['group_id'],
                'group_name' => $group['group_name'],
                'collapse' => true,
                'items' => self::getGroupedItems($grouped_finishes)
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
                'item_name' => $item['item_name'],
                'description' => $item['description'],
                
            ];

        }

        return $response;

    }
    
    public static function getFinishes($condominium_id)
    {
        $finishes = self::where('condominium_id',$condominium_id)
                        ->join('finish_groups','finish_groups.id','finishes.group_id')
                        ->join('finish_items','finish_items.id','finishes.item_id')
                        ->join('condominiums','condominiums.id','finishes.condominium_id')
                        ->select(
                            'finishes.id',
                            'finishes.description',
                            'finishes.group_id',
                            'finish_groups.name as group_name',
                            'finishes.item_id', 
                            'finish_items.name as item_name',
                            'condominiums.id as condominium_id',
                            'condominiums.name as condominium_name'
                        )->get();

        return $finishes;
    }
}
