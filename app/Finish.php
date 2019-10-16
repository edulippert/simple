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
        if ($grouped_items->first()['id']) {
            # code...
            foreach ($grouped_items as $item ) {
                
                $response[] = [
                    'id' => $item['id'],
                    'item_name' => $item['item_name'],
                    'description' => $item['description'],
                    
                ];
                
            }
            
        }
        return $response;

    }
    
    public static function getFinishes($condominium_id)
    {
        $finishes =     FinishGroup::where('condominium_id',$condominium_id)
                        ->leftjoin('finish_items','finish_items.group_id','finish_groups.id')
                        ->leftjoin('condominiums','condominiums.id','finish_groups.condominium_id')
                        ->select(
                            'finish_items.id',
                            'finish_items.name as item_name',
                            'finish_items.description',
                            'finish_groups.id as group_id',
                            'finish_groups.name as group_name',
                            'condominiums.id as condominium_id',
                            'condominiums.name as condominium_name'
                        )->get();

        return $finishes;
    }
}
