<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCondominium extends Model
{
    protected $fillable = ['user_company_id', 'condominium_id'];
    protected $guarded = ['id'];
    protected $table = 'user_condominiums';

    public function condominiums()
    {
        return $this->belongsTo(Condominium::class);
    }

    public function user_companies()
    {
        return $this->belongsTo(UserCompany::class,'user_company_id','id');
    }

}
