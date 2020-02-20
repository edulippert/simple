<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\MaintenanceProgram;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\MaintenanceProgramUpdatedEvent;

class CreateNextMaintenanceProgram
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MaintenanceProgramUpdatedEvent $event)
    {

        $maintenance = $event->getMaintenancePrograms();
       
        $start_date = $maintenance->maintenance_day;

        $customer_maintenance = $maintenance->customer_guarantee_maintenance;

        // x por mes
        if ($customer_maintenance->period == "1") {

            
            $loop_times = $customer_maintenance->amount;

            for ($j=1; $j <=12 ; $j++) { 
                
                $days_in_a_month = (int)(Carbon::createFromDate($start_date)->addMonth($j)->daysInMonth);
                
                $days_to_next_maintenance = 0;

                for ($i=1; $i <= $loop_times; $i++) {
                
                    $maintenance_program = MaintenanceProgram::create([
                        'customer_guarantee_maintenance_id' => $customer_maintenance->id,
                        'maintenance_day' => Carbon::createFromDate($start_date)->addMonth($j)->startOfMonth()->addDay($days_to_next_maintenance),
                        'is_blocked' => true,
                        'estimated_cost' => $maintenance->estimated_cost
                    ]);
                            
                    $days_to_next_maintenance += (int)($days_in_a_month/$customer_maintenance->amount);  
                }    
            }
        }

        // x por ano
        if ($customer_maintenance->period == "2") {

            $days_to_next_maintenance = (int)(365/$customer_maintenance->amount);

            $loop_times = $customer_maintenance->amount;
            
            for ($i=1; $i <= $loop_times; $i++) {
            
                $maintenance_program = MaintenanceProgram::create([
                    'customer_guarantee_maintenance_id' => $customer_maintenance->id,
                    'maintenance_day' => Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance),
                    'is_blocked' => true,
                    'estimated_cost' => $maintenance->estimated_cost
                ]);
                    
                $days_to_next_maintenance += (int)(365/$customer_maintenance->amount);  
            }    
        }

        // a cada x dias adicionado para o ano inteiro
        if ($customer_maintenance->period == "3") {
            
            $n_times_in_a_year = (int)(365/$customer_maintenance->amount);
            $days_to_next_maintenance = (int)$customer_maintenance->amount;

            for ($i=1; $i <= $n_times_in_a_year ; $i++) { 
                
                $maintenance_program = MaintenanceProgram::create([
                    'customer_guarantee_maintenance_id' => $customer_maintenance->id,
                    'maintenance_day' => Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance),
                    'is_blocked' => true,
                    'estimated_cost' => $maintenance->estimated_cost
                ]);

                $days_to_next_maintenance += (int)$customer_maintenance->amount; 

            }   
        }

        // a cada x semanas
        if ($customer_maintenance->period == "4") {
            
            $week_in_days = (int)(7*$customer_maintenance->amount);

            $n_times_in_a_year = (int)(365/$week_in_days);
            
            $days_to_next_maintenance = (int)$week_in_days;

            for ($i=1; $i <= $n_times_in_a_year ; $i++) { 
                
                $maintenance_program = MaintenanceProgram::create([
                    'customer_guarantee_maintenance_id' => $customer_maintenance->id,
                    'maintenance_day' => Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance),
                    'is_blocked' => true,
                    'estimated_cost' => $maintenance->estimated_cost
                ]);

                $days_to_next_maintenance += (int)$week_in_days; 

            }   
        }

        // a cada x meses
        if ($customer_maintenance->period == "5") {
            
            $month_in_days = (int)(30*$customer_maintenance->amount);

            $n_times_in_a_year = (int)(365/$month_in_days);
            
            $days_to_next_maintenance = (int)$month_in_days;

            for ($i=1; $i <= $n_times_in_a_year ; $i++) { 
                
                $maintenance_program = MaintenanceProgram::create([
                    'customer_guarantee_maintenance_id' => $customer_maintenance->id,
                    'maintenance_day' => Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance),
                    'is_blocked' => true,
                    'estimated_cost' => $maintenance->estimated_cost
                ]);

                $days_to_next_maintenance += (int)$month_in_days; 

            }   
        }

        // a cada x anos
        if ($customer_maintenance->period == "6") {
            
            $days_to_next_maintenance = (int)(365*$customer_maintenance->amount);

            $maintenance_program = MaintenanceProgram::create([
                'customer_guarantee_maintenance_id' => $customer_maintenance->id,
                'maintenance_day' => Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance),
                'is_blocked' => true,
                'estimated_cost' => $maintenance->estimated_cost
            ]);

        }

        /*if ( $customer_maintenance->period == "2" ) {
            $days_to_next_maintenance = (int)(365/$customer_maintenance->amount);
            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
        }elseif ($customer_maintenance->period == "1") {
            $days_to_next_maintenance = (int)(round(($days_in_a_month/$customer_maintenance->amount),0,PHP_ROUND_HALF_UP));
            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
        }elseif ($customer_maintenance->period == "3") {
            $days_to_next_maintenance = (int)($customer_maintenance->amount);
            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
        }elseif ($customer_maintenance->period == "4") {
            $days_to_next_maintenance = (int)(7*$customer_maintenance->amount);
            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
        }elseif ($customer_maintenance->period == "5") {
            $days_to_next_maintenance = (int)($days_in_a_month*$customer_maintenance->amount);
            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
        }elseif ($customer_maintenance->period == "6") {
            $days_to_next_maintenance = (int)(365*$customer_maintenance->amount);
            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
        }


        $maintenance_program = MaintenanceProgram::create([
            'customer_guarantee_maintenance_id' => $maintenance->customer_guarantee_maintenance_id,
            'maintenance_day' => $maintenance_date,
            'estimated_cost' => $maintenance->estimated_cost
        ]);*/
       

    }
}
