<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['description','is_guarantee'];
    protected $giuarded = ['id'];
    protected $table = 'groups';

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
