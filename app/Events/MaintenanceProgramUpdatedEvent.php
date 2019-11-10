<?php
declare(strict_types=1);
namespace App\Events;

use App\MaintenanceProgram;


class MaintenanceProgramUpdatedEvent
{
   

    private $program;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MaintenanceProgram $program)
    {
        $this->program = $program;
    }

   public function getMaintenancePrograms(): MaintenanceProgram
   {
       return $this->program;
   }
}
