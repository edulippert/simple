<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinishItem extends Model
{
    protected $fillable = ['name','description','group_id'];

    protected $table = 'finish_items';

    public function finish_group(){
        return $this->belongsTo(FinishGroup::class,'group_id');
    }
}
