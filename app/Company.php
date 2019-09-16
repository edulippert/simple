<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name','cnpj','address','complement','website','email','phone_number','responsible','cep'];

    protected $table = 'companies';

    public function user_companies()
    {
        return $this->hasMany(UserCompany::class);
    }
}
