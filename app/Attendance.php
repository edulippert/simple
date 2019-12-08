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

    public static function buildReportDetail($start_date,$end_date,$condominium_id,$is_finalized)
    {
        return self::where('call_date','>=',$start_date)
                    ->where('call_date','<=',$end_date )
                    ->join('condominiums','condominiums.id','attendances.condominium_id')
                    ->whereRaw('case when -1 = '.$condominium_id.' then true else condominium_id = '.$condominium_id.' end')
                    ->whereRaw('case '.$is_finalized.' when -1 then true when 1 then is_finalized = true else is_finalized = false end')
                    ->select(DB::raw(
                        "condominiums.name as condominium_name,
                        attendance_place,
                        call_date,
                        description,
                        contact_name,
                        contact_phone_number,
                        total_cost,
                        case when is_finalized = true then 'Finalizado' else 'Em Aberto' end as status 
                        ")
                    )
                    ->get();
    }

    public static function buildReportTotal($start_date,$end_date,$condominium_id,$is_finalized)
    {
        return self::where('call_date','>=',$start_date)
                    ->where('call_date','<=',$end_date )

                    ->whereRaw('case when -1 = '.$condominium_id.' then true else condominium_id = '.$condominium_id.' end')
                    ->whereRaw('case '.$is_finalized.' when -1 then true when 1 then is_finalized = true else is_finalized = false end')
                    ->select(DB::raw("sum(coalesce(total_cost,'0')::numeric) as total_cost"))
                    ->get();
    }

}
