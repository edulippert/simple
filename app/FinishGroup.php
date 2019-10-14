<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class FinishGroup extends Model
{
    protected $fillable = ['name','company_id'];

    protected $table = 'finish_groups';

    public static function getDistinctGroups($root_colletion):array
    {

        $response = [];

        $groups = $root_colletion->map->only(['group_id','group_name']);
        
        $group_collection = new Collection($groups);
        
        $unique_groups = $group_collection->unique();

        foreach ($unique_groups as $unique_group) {
        
            $response[] = [
                'group_id' => $unique_group['group_id'],
                'group_name' => $unique_group['group_name']
            ];
        }
        
        return $response;
    }



    public function finish_items(){
        return $this->hasMany(FinishItem::class,'group_id');
    }
}
