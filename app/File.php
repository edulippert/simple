<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['file','name','type','subtype'];

    protected $table = 'files';
}
