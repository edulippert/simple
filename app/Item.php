<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['group_id', 'description'];
    protected $guarded = ['id'];
    protected $table = 'items';

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function subitems()
    {
        return $this->hasMany(Subitem::class);
    }
}
