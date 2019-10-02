<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Group extends Model
{
    protected $fillable = ['description','is_guarantee'];
    protected $giuarded = ['id'];
    protected $table = 'groups';

    
    public static function getDistinctGroups($root_colletion)
    {
        $groups = $root_colletion->map->only(['group_id','group_description']);
        
        $group_collection = new Collection($groups);
        
        $unique_groups = $group_collection->unique();
        
        return $unique_groups;
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
