<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['group_id', 'description'];
    protected $guarded = ['id'];
    protected $table = 'items';

    public static function getDistinctItems($root_colletion)
    {
        $items = $root_colletion->map->only(['items_id','items_description']);
        
        $item_collection = new Collection($items);
        
        $unique_items = $item_collection->unique();
        
        return $unique_items;
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function subitems()
    {
        return $this->hasMany(Subitem::class);
    }
}
