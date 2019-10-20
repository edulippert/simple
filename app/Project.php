<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['condominium_id', 'file_id', 'name'];
    protected $guarded = ['id'];
    protected $table = 'projects';

    public function condominiums()
    {
        return $this->belongsTo(Condominium::class);
    }

    public function file(){
        return $this->belongsTo(File::class,'file_id');
    }
}
