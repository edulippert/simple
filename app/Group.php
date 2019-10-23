<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Group extends Model
{
    protected $fillable = ['description','is_guarantee','is_maintenance'];
    protected $giuarded = ['id'];
    protected $table = 'groups';

    
    public static function getDistinctGroups($root_colletion):array
    {

        $response = [];

        $groups = $root_colletion->map->only(['group_id','group_description']);
        
        $group_collection = new Collection($groups);
        
        $unique_groups = $group_collection->unique();

        foreach ($unique_groups as $unique_group) {
        
            $response[] = [
                'group_id' => $unique_group['group_id'],
                'group_description' => $unique_group['group_description']
            ];
        }
        
        return $response;
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
