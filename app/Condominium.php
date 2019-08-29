<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condominium extends Model
{
    protected $fillable = [
        'company_id',
        'file_id',
        'name',
        'id_number',
        'address',
        'complement',
        'zipcode',
        'licence_due_date',
        'is_active'
    ];

    protected $guarded = ['id'];

    protected $table = 'condominiums';

    public function companies() {
        return $this->belongsTo(company::class);
    }

    public function files() {
        return $this->hasMany(File::class);
    }
}