<?php

namespace App\Http\Resources;

use App\Condominium;
use Illuminate\Http\Resources\Json\JsonResource;

class CondominiumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $condomimiun = Condominium::find($this->id);
        $condomimiun_guarantees = $condomimiun->customer_guarantees->first();
        $condomimiun_maintenances = $condomimiun->customer_guarantee_maintenances->first();

        if ($condomimiun_guarantees || $condomimiun_maintenances) {
            $distributed = true;
        }else{
            $distributed = false;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'licence_due_date' => $this->licence_due_date,
            'address' => $this->address,
            'distributed' => $distributed,
            'company' => new CompanyResource($this->companies)
        ];
    }
}
