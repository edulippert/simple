<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['description'];
    protected $guarded = ['id'];
    protected $table = 'roles';

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
