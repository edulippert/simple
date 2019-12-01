<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    
    protected $fillable = [
        'company_id',
        'file_id',
        'attendance_place',
        'call_date',
        'inspection_date',
        'finish_date',
        'description',
        'solution',
        'responsible',
        'manpower_cost',
        'material_cost',
        'total_cost',
        'contact_name',
        'contact_email',
        'contact_phone_number',
        'condominium_id',
        'is_finalized'
    ];

    protected $table = 'attendances';

    
    public static function getAcceptanceTerm($attendance_id)
    {
        $attendance = self::where('attendances.id',$attendance_id)
                            ->join('companies','companies.id','attendances.company_id')
                            ->join('condominiums','condominiums.id','attendances.condominium_id')
                            ->select(
                                'companies.name as company_name',
                                'attendances.description',
                                'attendances.attendance_place',
                                'condominiums.name',
                                'condominiums.address'
                            )->first();

        return $attendance;
    }

    public static function buildAttendanceGraphResponse($company_id,$month,$year)
    {
        $condominiums = Condominium::whereCompanyId($company_id)->get();

        $response = [];
        foreach ($condominiums as $condominium) {
            
            $attendance_cost = self::getTotalCostAttendacesByCondominium($condominium->id,$month,$year)->first();

            $response[] = [
                'condominium_id' => $condominium->id,
                'name' => $condominium->name,
                'total_cost' => $attendance_cost?$attendance_cost->total_cost:0,
            ];

        }

        return $response;
    }

    public static function getTotalCostAttendacesByCondominium($condominium_id,$month=null,$year=null)
    {
        return  self::whereCondominiumId($condominium_id)
                    //->whereRaw('extract(month from finish_date) = '.$month)
                    //->whereRaw('extract(year from finish_date) = '.$year)
                    ->select('condominium_id')
                    ->select(DB::raw("sum(coalesce(total_cost,'0')::numeric) as total_cost"))
                    ->groupBy('condominium_id')
                    ->get();
    }
}
