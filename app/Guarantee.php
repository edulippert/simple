<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guarantee extends Model
{
    protected $fillable = ['name','description','is_pattern'];

    protected $table = 'guarantees';

    protected $guarded = ['id'];

    public function rootGuarantees(){
        return $this->hasMany(RootGuarantee::class,'guarantee_id');
    }
}
