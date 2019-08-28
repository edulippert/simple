<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $fillable = ['condominium_id', 'option_id', 'file_id', 'description'];
    protected $guarded = ['id'];
    protected $table = 'licenses';

    public function option()
    {
        return $this->belongsTo(LicenseOption::class);
    }
}
