<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCondominium extends Model
{
    protected $fillable = ['condominium_id', 'user_id'];
    protected $guarded = ['id'];
    protected $table = 'user_condominiums';

    public function condominiums()
    {
        return $this->belongsTo(Condominum::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
