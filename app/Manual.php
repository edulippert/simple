<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{
    protected $fillable = [
        'condominium_id',
        'file_id',
        'name'
    ];

    protected $table = 'manuals';

    public function file(){
        return $this->belongsTo(File::class,'file_id');
    }
}
