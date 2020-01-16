<?php

namespace App;

use App\CustomerGuaranteeMaintenance;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CustomerGuarantee extends Model
{
    protected $fillable = [ 'condominium_id',
                            'group_id',
                            'item_id',
                            'subitem_id',
                            'start_date',
                            'amount',
                            'period',
                            'due_date',
                            'is_active',
                            'is_expired',
                            'reference',
                            'coverage',
                            'status'
                        ];
                        
    protected $table = 'customer_guarantees';

    public static function buildGuaranteesResponse($condominium_id)
    {

        $customer_guarantees = self::getCustomerGuarantee($condominium_id);

        $groups = Group::getDistinctGroups($customer_guarantees);


        $response = [];
        foreach ($groups as $group) {
            $grouped_customer_guarantee = $customer_guarantees->where('group_id',$group['group_id']);

            $response[] = [
                'group_description' => $group['group_description'],
                'collapse' => true,
                'guarantees' => self::getGroupedGuarantees($grouped_customer_guarantee)
            ];

        }
        return $response;

    }

    public static function getGroupedGuarantees($grouped_guarantees)
    {

        $response = [];

        foreach ($grouped_guarantees as $grouped_guarantee) {

            //$qt_days = $grouped_guarantee->due_date - $grouped_guarantee->start_date;
            if ($grouped_guarantee->qt_days_current < 0){
                $qt_days_current = 0;
            }else{
                $qt_days_current = $grouped_guarantee->qt_days_current;
            }


            if ($grouped_guarantee->qt_days_guarantee == 0){
                $percent_evaluation = 0;
            }else{
                $percent_evaluation = ($qt_days_current*100)/$grouped_guarantee->qt_days_guarantee;
            }

            

            //if ($grouped_guarantee->status == '') {
                if ($grouped_guarantee->due_date < Carbon::now()) {
                    $status = 'Expirada';
                }else{
                    $status = 'Ativa';
                }
            //}else{
               // $status = $grouped_guarantee->status;
            //}
            
            $response[] = [
                'item_description' => $grouped_guarantee->item_description,
                'coverage' => $grouped_guarantee->coverage,
                'start_date' => $grouped_guarantee->start_date,
                'due_date' => $grouped_guarantee->due_date,
                'percent_evaluation' => $percent_evaluation,
                'guarantee_time' => $grouped_guarantee->qt_days_guarantee == 0 ? 'Na Entrega' : $grouped_guarantee->amount.' '.$grouped_guarantee->period,
                'status' => $status
               
            ];

        }

        return $response;

    }

    public static function buildGuaranteeMaintenancesAllocatedsResponse($condominium_id)
    {

        $customer_guarantees = self::getCustomerGuarantee($condominium_id);

        $array_just_maintenances = [];

        $response = [];

        foreach ($customer_guarantees as $customer_guarantee) {
            
            $response[] = [
                'id' => $customer_guarantee->id,
                'group_id' => $customer_guarantee->group_id,
                'group_description' => $customer_guarantee->group_description,
                'item_id' => $customer_guarantee->item_id,
                'item_description' => $customer_guarantee->item_description,
                'start_date' => $customer_guarantee->start_date,
                'amount' => $customer_guarantee->amount,
                'period' => $customer_guarantee->period,
                'due_date' => $customer_guarantee->due_date,
                'is_active' => $customer_guarantee->is_active,
                'is_expired' => $customer_guarantee->is_expired,
                'reference' => $customer_guarantee->reference,
                'coverage' => $customer_guarantee->coverage,
                'collapse' => true,
                'maintenances' => CustomerGuaranteeMaintenance::getGuaranteeMaintenaces($customer_guarantee->id)
            ];


        }

        $get_just_maintenances = CustomerGuaranteeMaintenance::getJustMaintenances($condominium_id);

        if ($get_just_maintenances->first()) {
            $array_just_maintenances = [
                'id' => null,
                'description' => 'Sem Garantias',
                'collapse' => true,
                'maintenances' => $get_just_maintenances
            ];

            array_push($response,$array_just_maintenances); 

        } 
        
        return $response;

    }

    public static function getCustomerGuarantee($condominium_id){
        
        $customer_guarantee = self::where('condominium_id',$condominium_id)
                                ->join('groups','groups.id','group_id')
                                ->join('items','items.id','item_id')
                                ->select(
                                    'customer_guarantees.id',
                                    'customer_guarantees.condominium_id',
                                    'groups.description as group_description',
                                    'customer_guarantees.group_id',
                                    'items.description as item_description',
                                    'customer_guarantees.item_id',
                                    'customer_guarantees.start_date',
                                    'customer_guarantees.amount',
                                    'customer_guarantees.period',
                                    'customer_guarantees.due_date',
                                    'customer_guarantees.is_active',
                                    'customer_guarantees.is_expired',
                                    'customer_guarantees.reference',
                                    'customer_guarantees.coverage',
                                    'customer_guarantees.status',
                                    DB::raw('extract(day from (customer_guarantees.due_date - customer_guarantees.start_date)) as qt_days_guarantee '),
                                    DB::raw('extract(day from (current_date - customer_guarantees.start_date)) as qt_days_current')
                                )
                                ->get();
                                  //  dd($customer_guarantee);
        return $customer_guarantee;

    }

    public function item(){
        return $this->belongsTo(Item::class,'item_id');
    }
         
}
