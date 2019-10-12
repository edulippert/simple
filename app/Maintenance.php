<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = ['name','description'];

    protected $table = 'maintenances';

    protected $guarded = ['id'];

    public function rootMaintenances(){
        return $this->hasMany(RootMaintenance::class,'maintenance_id');
    }
}
