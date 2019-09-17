<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    protected $fillable = ['company_id', 'user_id'];
    protected $guarded = ['id'];
    protected $table = 'user_companies';

    public function companies()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }

    public function users()
    {
      return $this->belongsTo(User::class);
    }

    public function user_condominiums()
    {
      return $this->hasMany(UserCondominium::class,'user_company_id','id');
    }
}