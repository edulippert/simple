<?php

namespace App;

use App\CustomerGuaranteeMaintenance;
use Illuminate\Database\Eloquent\Model;

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
                            'reference'
                        ];
                        
    protected $table = 'customer_guarantees';


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
                                    'customer_guarantees.reference'
                                )
                                ->get();

        return $customer_guarantee;

    }
         
}
