<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $fillable = ['condominium_id', 'file_id', 'description'];
    protected $guarded = ['id'];
    protected $table = 'licenses';


    public static function getLicenses($condominium_id)
    {

        $licenses_options = LicenseOption::all();

        $licenses = self::whereCondominiumId($condominium_id)->get();

        $response = [];

        foreach ($licenses_options as $licenses_option) {
            
            $response[] = [
                'id' => $licenses_option->id,
                'name' => $licenses_option->name,
                'licenses' => [$licenses->where('condominium_id',$licenses_option->id)->first()]
            ];
        }

        return $response;

    }

    public static function buildLicenseResponse($condominium_id)
    {
        $licenses = License::whereCondominiumId($condominium_id)->get();

        $response=[];

        foreach ($licenses as $license) {
            
            $response[] = [
                'condominium_id' => $license->condominium_id, 
                'file_id' => $license->file_id, 
                'file_name' => $license->file ? $license->file->file : null,
                'description' => $license->description    
            ];
        }
    }

    public function option()
    {
        return $this->belongsTo(LicenseOption::class,'option_id');
    }

    public function file(){
        return $this->belongsTo(File::class,'file_id');
    }
}
