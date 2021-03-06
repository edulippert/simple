<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MaintenanceProgram extends Model
{
    protected $fillable = [
                            'customer_guarantee_maintenance_id',
                            'file_id',
                            'maintenance_day',
                            'executed_day',
                            'status',
                            'is_done',
                            'is_blocked',
                            'estimated_cost',
                            'executed_cost',
                            'condominium_comments',
                            'company_comments',
                            'responsible'
                        ];

    protected $table = 'maintenance_programs';

    protected $guarded = ['id'];

    public static function need_to_call_event($customer_guarantee_maintenance_id,$maintenance_date)
    {
        $maintenance_program = self::where('customer_guarantee_maintenance_id',$customer_guarantee_maintenance_id)
                                ->where('maintenance_day','>',$maintenance_date)->first();

        if ($maintenance_program) {
            return false;
        }else{
            return true;
        }

    }

    public static function get_maintenance_info_by_month($condominium_id,$month,$year)
    {
        $maintenance_headers = self::getMaintenanceHeader($condominium_id,$month,$year);

        $response = [];

        foreach ($maintenance_headers as $maintenance_header) {

            switch ($maintenance_header->just_month) {
                case '01':
                    $text_month = 'Janeiro';
                    break;
                case '02':
                    $text_month = 'Fevereiro';
                    break;
                case '03':
                    $text_month = 'Março';
                    break;
                case '04':
                    $text_month = 'Abril';
                    break;
                case '05':
                    $text_month = 'Maio';
                    break;
                case '06':
                    $text_month = 'Junho';
                    break;
                case '07':
                    $text_month = 'Julho';
                    break;
                case '08':
                    $text_month = 'Agosto';
                    break;
                case '09':
                    $text_month = 'Setembro';
                    break;
                case '10':
                    $text_month = 'Outubro';
                    break;
                case '11':
                    $text_month = 'Novembro';
                    break;
                case '12':
                    $text_month = 'Dezembro';
                    break;
            }

            if ($maintenance_header->total != 0) {

                $percent_done = round(($maintenance_header->nr_done * 100) / $maintenance_header->total);

            }else{

                $percent_done = 0;
            }

            $response[] = [
                'month_year' => $text_month.'/'.$maintenance_header->just_year,
                'tasks_done' => $maintenance_header->nr_done,
                'tasks_not_done' => $maintenance_header->nr_not_done,
                'total_tasks' => $maintenance_header->total,
                'percent_done' => $percent_done,
                'estimated_cost' => $maintenance_header->estimated_cost,
                'executed_cost' => $maintenance_header->executed_cost,
            ];
        }

        return $response;
    }


    public static function buildMaintenanceResponse($condominium_id)
    {

        $maintenance_headers = self::getMaintenanceHeader($condominium_id);

        $response = [];

        $response[] = [
            'month_year' => 'Lembretes Diarios',
            'tasks_done' => 0,
            'tasks_not_done' => 0,
            'percent_done' => 0,
            'estimated_cost' => 0,
            'executed_cost' => 0,
            'is_informed' => false,
            'collapse' => false,
            'maintenances' => self::getMaintenacesByMonth($condominium_id,null,null,false)
        ];

        $now = Carbon::now();



        foreach ($maintenance_headers as $maintenance_header) {

            $collapse = false;

            if ($now->month == (int)$maintenance_header->just_month) {
                $collapse = true;
            }
            //$nr_month = Str::substr($maintenance_header->month_year,0,2);
            //$nr_year = Str::substr($maintenance_header->month_year,3,4);

            switch ($maintenance_header->just_month) {
                case '01':
                    $text_month = 'Janeiro';
                    break;
                case '02':
                    $text_month = 'Fevereiro';
                    break;
                case '03':
                    $text_month = 'Março';
                    break;
                case '04':
                    $text_month = 'Abril';
                    break;
                case '05':
                    $text_month = 'Maio';
                    break;
                case '06':
                    $text_month = 'Junho';
                    break;
                case '07':
                    $text_month = 'Julho';
                    break;
                case '08':
                    $text_month = 'Agosto';
                    break;
                case '09':
                    $text_month = 'Setembro';
                    break;
                case '10':
                    $text_month = 'Outubro';
                    break;
                case '11':
                    $text_month = 'Novembro';
                    break;
                case '12':
                    $text_month = 'Dezembro';
                    break;
            }

            if ($maintenance_header->total != 0) {

                $percent_done = round(($maintenance_header->nr_done * 100) / $maintenance_header->total);

            }else{

                $percent_done = 0;
            }




            $response[] = [
                'month_year' => $text_month.'/'.$maintenance_header->just_year,
                'tasks_done' => $maintenance_header->nr_done,
                'tasks_not_done' => $maintenance_header->nr_not_done,
                'percent_done' => $percent_done,
                'estimated_cost' => $maintenance_header->estimated_cost,
                'executed_cost' => $maintenance_header->executed_cost,
                'is_informed' => $maintenance_header->is_informed,
                'collapse' => $collapse,
                'maintenances' => self::getMaintenacesByMonth($condominium_id,$maintenance_header->just_month,$maintenance_header->just_year)
            ];
        }

        return $response;

    }

    public static function getMaintenacesByMonth($condominium_id,$month,$year,$is_informed = true)
    {
        $maintenances = self::getMaintenancesPrograms($condominium_id,$month,$year,$is_informed);

        $response = [];
        foreach ($maintenances as $maintenance) {

            $status = 'Aberto';

            if ($maintenance->executed_day != null) {
                if ($maintenance->executed_day > $maintenance->maintenance_day) {
                    $status = 'Executado com atraso';
                }else{
                    $status = 'Executado';
                }
            }else{
                if ($maintenance->maintenance_day < Carbon::now()) {
                    $status = 'Atrasado';
                }
            }

            $response[] = [
                'id' => $maintenance->id,
                'day' => $maintenance->is_informed? $maintenance->just_day:' - ',
                'file_id' => $maintenance->file_id,
                'item_id' => $maintenance->item_id,
                'item_description' => $maintenance->item_description,
                'activity' => $maintenance->activity,
                'executed_day' => $maintenance->executed_day,
                'estimated_cost' => $maintenance->estimated_cost,
                'executed_cost' => $maintenance->executed_cost,
                'status' => $maintenance->is_informed ? $status:'Nao Informar',
                'amount' => $maintenance->amount,
                'period' => $maintenance->period,
                'is_blocked' => $maintenance->is_blocked,
                'is_done' => $maintenance->is_done

            ];
        }

        return $response;

    }

    public static function buildCompanyCondominiumsGroupedByMaintenancesPercent($company_id,$month=null,$year=null)
    {
        $condominiums = Condominium::whereCompanyId($company_id)->get();

        $response = [];

        foreach ($condominiums as $condominium) {

            switch ($month) {
                case 1:
                    $text_month = 'Janeiro';
                    break;
                case 2:
                    $text_month = 'Fevereiro';
                    break;
                case 3:
                    $text_month = 'Março';
                    break;
                case 4:
                    $text_month = 'Abril';
                    break;
                case 5:
                    $text_month = 'Maio';
                    break;
                case 6:
                    $text_month = 'Junho';
                    break;
                case 7:
                    $text_month = 'Julho';
                    break;
                case 8:
                    $text_month = 'Agosto';
                    break;
                case 9:
                    $text_month = 'Setembro';
                    break;
                case 10:
                    $text_month = 'Outubro';
                    break;
                case 11:
                    $text_month = 'Novembro';
                    break;
                case 12:
                    $text_month = 'Dezembro';
                    break;
            }

            $maintenance_header = self::getMaintenanceHeader($condominium->id,$month,$year)->first();


            if ($maintenance_header) {



                if ($maintenance_header->total != 0) {

                    $percent_done = round(($maintenance_header->nr_done * 100) / $maintenance_header->total);

                }else{

                    $percent_done = 0;
                }

                $response[] = [
                    'condominium_id' => $condominium->id,
                    'name' => $condominium->name,
                    'text_month' => $text_month,
                    'percent_done' => $percent_done

                ];
            }else{

                $response[] = [
                    'condominium_id' => $condominium->id,
                    'name' => $condominium->name,
                    'text_month' => $text_month,
                    'percent_done' => 0

                ];
            }

        }

        return $response;
    }

    public static function getMaintenanceHeader($condominium_id,$month=null,$year=null)
    {

        if ($year) {

            if ($month) {

                $grouped_maintenances = self::where('customer_guarantee_maintenances.condominium_id',$condominium_id)
                                        ->whereRaw('extract(month from maintenance_day) = '.$month)
                                        ->whereRaw('extract(year from maintenance_day) = '.$year)
                                       // ->where('customer_guarantee_maintenances.is_informed','true')
                                        ->leftjoin('customer_guarantee_maintenances','customer_guarantee_maintenances.id','maintenance_programs.customer_guarantee_maintenance_id')
                                        ->select(DB::raw("lpad(extract(month from maintenance_day)::text,2,'0') || '/' || extract(year from maintenance_day)::text as month_year,
                                        extract(month from maintenance_day) as just_month,
                                        extract(year from maintenance_day) as just_year,
                                        sum(case when is_done = true then 1 else 0 end ) as nr_done,
                                        sum(case when is_done = false then 1 else 0 end ) as nr_not_done,
                                        sum(estimated_cost) as estimated_cost,
                                        sum(executed_cost) as executed_cost,
                                        count(*) as total"))
                                        ->groupBy('month_year','just_month','just_year')
                                        ->orderBy('just_year','asc')
                                        ->orderBy('just_month','asc')
                                        ->get();
            }else{

                $grouped_maintenances = self::where('customer_guarantee_maintenances.condominium_id',$condominium_id)
                                        ->whereRaw('extract(year from maintenance_day) = '.$year)
                                     //   ->where('customer_guarantee_maintenances.is_informed','true')
                                        ->leftjoin('customer_guarantee_maintenances','customer_guarantee_maintenances.id','maintenance_programs.customer_guarantee_maintenance_id')
                                        ->select(DB::raw("lpad(extract(month from maintenance_day)::text,2,'0') || '/' || extract(year from maintenance_day)::text as month_year,
                                        extract(month from maintenance_day) as just_month,
                                        extract(year from maintenance_day) as just_year,
                                        sum(case when is_done = true then 1 else 0 end ) as nr_done,
                                        sum(case when is_done = false then 1 else 0 end ) as nr_not_done,
                                        sum(estimated_cost) as estimated_cost,
                                        sum(executed_cost) as executed_cost,
                                        count(*) as total"))
                                        ->groupBy('month_year','just_month','just_year')
                                        ->orderBy('just_year','asc')
                                        ->orderBy('just_month','asc')
                                        ->get();
            }

        }else{

            $grouped_maintenances = self::where('customer_guarantee_maintenances.condominium_id',$condominium_id)
                                    ->leftjoin('customer_guarantee_maintenances','customer_guarantee_maintenances.id','maintenance_programs.customer_guarantee_maintenance_id')
                                   //->where('customer_guarantee_maintenances.is_informed','true')
                                    ->select(DB::raw("lpad(extract(month from maintenance_day)::text,2,'0') || '/' || extract(year from maintenance_day)::text as month_year,
                                    extract(month from maintenance_day) as just_month,
                                    extract(year from maintenance_day) as just_year,
                                    sum(case when is_done = true then 1 else 0 end ) as nr_done,
                                    sum(case when is_done = false then 1 else 0 end ) as nr_not_done,
                                    sum(estimated_cost) as estimated_cost,
                                    sum(executed_cost) as executed_cost,
                                    count(*) as total"))
                                    ->groupBy('month_year','just_month','just_year')
                                    ->orderBy('just_year','asc')
                                    ->orderBy('just_month','asc')
                                    ->get();
        }


        return $grouped_maintenances;
    }

    public static function getMaintenancesPrograms($condominium_id,$month=null,$year=null,$is_informed = true)
    {
        if ($month) {

            $maintenance_programs = self::where('customer_guarantee_maintenances.condominium_id',$condominium_id)
                                    ->whereRaw('extract(month from maintenance_day) = '.$month)
                                    ->whereRaw('extract(year from maintenance_day) = '.$year)
                                    ->where('customer_guarantee_maintenances.is_informed',$is_informed)
                                    ->join('customer_guarantee_maintenances','customer_guarantee_maintenances.id','maintenance_programs.customer_guarantee_maintenance_id')
                                    ->join('groups','groups.id','customer_guarantee_maintenances.group_id')
                                    ->join('items','items.id','customer_guarantee_maintenances.item_id')
                                    ->select(DB::raw("extract(month from maintenance_day) as just_month,extract(year from maintenance_day) as just_year,extract(day from maintenance_day) as just_day"),
                                        'maintenance_programs.id',
                                        'file_id',
                                        'customer_guarantee_maintenances.group_id',
                                        'groups.description as group_description',
                                        'customer_guarantee_maintenances.item_id',
                                        'items.description as item_description',
                                        'customer_guarantee_maintenances.activity',
                                        'customer_guarantee_maintenances.description',
                                        'customer_guarantee_maintenances.amount',
                                        'customer_guarantee_maintenances.period',
                                        'customer_guarantee_maintenances.is_informed',
                                        'maintenance_day',
                                        'executed_day',
                                        'status',
                                        'estimated_cost',
                                        'executed_cost',
                                        'is_done',
                                        'is_blocked'
                                    )
                                    ->orderBy('maintenance_day')
                                    ->get();
        }else{

            $maintenance_programs = self::where('customer_guarantee_maintenances.condominium_id',$condominium_id)
                                    ->where('customer_guarantee_maintenances.is_informed',$is_informed)
                                    ->join('customer_guarantee_maintenances','customer_guarantee_maintenances.id','maintenance_programs.customer_guarantee_maintenance_id')
                                    ->join('groups','groups.id','customer_guarantee_maintenances.group_id')
                                    ->join('items','items.id','customer_guarantee_maintenances.item_id')
                                    ->select(DB::raw("extract(month from maintenance_day) as just_month,extract(year from maintenance_day) as just_year"),
                                        'maintenance_programs.id',
                                        'customer_guarantee_maintenances.group_id',
                                        'groups.description as group_description',
                                        'customer_guarantee_maintenances.item_id',
                                        'items.description as item_description',
                                        'customer_guarantee_maintenances.activity',
                                        'customer_guarantee_maintenances.description',
                                        'customer_guarantee_maintenances.amount',
                                        'customer_guarantee_maintenances.period',
                                        'customer_guarantee_maintenances.is_informed',
                                        'maintenance_day',
                                        'executed_day',
                                        'status',
                                        'is_done',
                                        'is_blocked'
                                    )
                                    ->orderBy('maintenance_day')
                                    ->get();
        }
        return $maintenance_programs;

    }


    public static function getNotInformedMaintenaces($condominium_id)
    {
        $maintenance_programs = self::where('customer_guarantee_maintenances.condominium_id',$condominium_id)
                                    ->where('customer_guarantee_maintenances.is_informed','false')
                                    ->join('customer_guarantee_maintenances','customer_guarantee_maintenances.id','maintenance_programs.customer_guarantee_maintenance_id')
                                    ->join('groups','groups.id','customer_guarantee_maintenances.group_id')
                                    ->join('items','items.id','customer_guarantee_maintenances.item_id')
                                    ->select(DB::raw("extract(month from maintenance_day) as just_month,extract(year from maintenance_day) as just_year"),
                                        'maintenance_programs.id',
                                        'customer_guarantee_maintenances.group_id',
                                        'groups.description as group_description',
                                        'customer_guarantee_maintenances.item_id',
                                        'items.description as item_description',
                                        'customer_guarantee_maintenances.activity',
                                        'customer_guarantee_maintenances.description',
                                        'customer_guarantee_maintenances.amount',
                                        'customer_guarantee_maintenances.period',
                                        'customer_guarantee_maintenances.is_informed',
                                        'maintenance_day',
                                        'executed_day',
                                        'status',
                                        'is_done',
                                        'is_blocked'
                                    )
                                    ->orderBy('maintenance_day')
                                    ->get();

        return $maintenance_programs;

    }
    public static function buildReportDetail($start_date,$end_date,$condominium_id)
    {
        $maintenance_programs = self::where('customer_guarantee_maintenances.condominium_id',$condominium_id)
        ->where('maintenance_day','>=',$start_date)
        ->where('maintenance_day','<=',$end_date)
        ->leftjoin('customer_guarantee_maintenances','customer_guarantee_maintenances.id','maintenance_programs.customer_guarantee_maintenance_id')
        ->join('groups','groups.id','customer_guarantee_maintenances.group_id')
        ->join('items','items.id','customer_guarantee_maintenances.item_id')
        ->select(DB::raw("
                            case when executed_day is not null then
                                case
                                    when executed_day > maintenance_day then
                                        'Executado com atraso'
                                    else
                                        'Executado'
                                end
                            else
                               case when maintenance_day > current_date then
                                    'Atrasado'
                                else
                                    'Em Aberto'
                                end
                            end as status"),
            'groups.description as group_description',
            'items.description as item_description',
            'customer_guarantee_maintenances.activity',
            'customer_guarantee_maintenances.amount',
            'customer_guarantee_maintenances.period',
            'maintenance_day',
            'executed_day',
            'estimated_cost',
            'executed_cost',
            'is_done',
            'is_blocked'
        )
        ->orderBy('maintenance_day')
        ->get();

        return $maintenance_programs;

    }

    public function file(){
        return $this->belongsTo(File::class,'file_id');
    }

    function customer_guarantee_maintenance()
    {
        return $this->belongsTo(CustomerGuaranteeMaintenance::class, 'customer_guarantee_maintenance_id' , 'id');
    }

}
