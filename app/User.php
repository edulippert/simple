<?php

namespace App;

use App\Role;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    //protected $dates = ['deleted_at'];

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

    public static function buildUserReponse(){
        
        $roles = Role::all();

        $response=[];

        foreach ($roles as $role) {
            $response[] = [
                'role_id' => $role->id,
                'role_description' => $role->description,
                'collapse' => true,
                'users' => self::getUserAndAssignments($role)
            ];
        }

        return $response;

    }

    public static function getUserAndAssignments($role = null)
    {
        if ($role){
        
            $user_assignments = 
                        self::where('roles.id',$role->id)
                        ->leftjoin('user_companies','users.id','user_companies.user_id')
                        ->leftjoin('companies','companies.id','user_companies.company_id')
                        ->leftJoin('user_condominiums','user_condominiums.user_company_id','user_companies.id')
                        ->leftJoin('condominiums','condominiums.id','user_condominiums.condominium_id')
                        ->leftJoin('roles','roles.id','users.role_id')
                        ->select('users.username','users.id',
                        'roles.description',
                        'users.email',
                        'users.phone_number',
                        'companies.name as company_name',
                        'condominiums.name as condominium_name')->get();
        

        }else{

            $user_assignments = 
                            self::leftjoin('user_companies','users.id','user_companies.user_id')
                            ->leftjoin('companies','companies.id','user_companies.company_id')
                            ->leftJoin('user_condominiums','user_condominiums.user_company_id','user_companies.id')
                            ->leftJoin('condominiums','condominiums.id','user_condominiums.condominium_id')
                            ->leftJoin('roles','roles.id','users.role_id')
                            ->select('users.username','users.id',
                            'roles.description',
                            'users.email',
                            'users.phone_number',
                            'companies.name as company_name',
                            'condominiums.name as condominium_name')->get();
            
        }

        return $user_assignments;
        
        
    }

    public static function showUserAndAssignments($id){
        $user_assignments = //DB::table('users')
                            self::where('users.id',$id)
                            ->leftjoin('user_companies','users.id','user_companies.user_id')
                            ->leftjoin('companies','companies.id','user_companies.company_id')
                            ->leftJoin('user_condominiums','user_condominiums.user_company_id','user_companies.id')
                            ->leftJoin('condominiums','condominiums.id','user_condominiums.condominium_id')
                            ->leftJoin('roles','roles.id','users.role_id')
                            ->select('users.username','users.id','users.id_number','users.cep','users.address','users.complement',
                            'roles.description',
                            'roles.id as roles_id',
                            'users.email',
                            'users.phone_number',
                            'companies.name as company_name',
                            'companies.id as company_id',
                            'condominiums.id as condominium_id',
                            'condominiums.name as condominium_name')->first();

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
        return $this->hasOne(UserCompany::class,'user_id');
    }
}
