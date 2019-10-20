<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LicenseOption extends Model
{
    protected $fillable = ['name'];
    protected $guarded = ['id'];
    protected $table = 'license_options';

    public function licenses()
    {
        return $this->hasMany(License::class,'option_id');
    }
}
