<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = ['name','description'];

    protected $table = 'maintenances';

    protected $guarded = ['id'];
}
