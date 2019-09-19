<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'role_id',
        'username',
        'email',
        'password',
        'id_number',
        'cep',
        'address',
        'complement',
        'phone_number',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users';

    public static function getUserAndAssignments()
    {

        $user_assignments = DB::table('users')
                            ->join('user_companies','users.id','user_companies.user_id')
                            ->join('companies','companies.id','user_companies.company_id')
                            ->select('users.username','users.email','users.phone_number','companies.name')->get();
        return $user_assignments;

        
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function user_companies()
    {
        return $this->hasMany(UserCompany::class);
    }
}
