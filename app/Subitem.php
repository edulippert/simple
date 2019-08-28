<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subitem extends Model
{
    protected $fillable = ['item_id', 'description'];
    protected $guarded = ['id'];
    protected $table = 'subitems';

    public function group()
    {
        return $this->belongsTo(Item::class);
    }
}
