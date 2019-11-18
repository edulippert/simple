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

        if ( $customer_maintenance->period == "2" ) {
            $days_to_next_maintenance = (int)(365/$customer_maintenance->amount);
            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
        }elseif ($customer_maintenance->period == "1") {
            $days_to_next_maintenance = (int)(30/$customer_maintenance->amount);
            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
        }elseif ($customer_maintenance->period == "3") {
            $days_to_next_maintenance = (int)($customer_maintenance->amount);
            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
        }elseif ($customer_maintenance->period == "4") {
            $days_to_next_maintenance = (int)(7*$customer_maintenance->amount);
            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
        }elseif ($customer_maintenance->period == "5") {
            $days_to_next_maintenance = (int)(30*$customer_maintenance->amount);
            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
        }elseif ($customer_maintenance->period == "6") {
            $days_to_next_maintenance = (int)(365*$customer_maintenance->amount);
            $maintenance_date = Carbon::createFromFormat('Y-m-d', $start_date )->addDay($days_to_next_maintenance);
        }


        $maintenance_program = MaintenanceProgram::create([
            'customer_guarantee_maintenance_id' => $maintenance->customer_guarantee_maintenance_id,
            'maintenance_day' => $maintenance_date
        ]);
       

    }
}
