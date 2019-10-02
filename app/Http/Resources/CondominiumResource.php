<?php

namespace App\Http\Resources;

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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'licence_due_date' => $this->licence_due_date,
            'address' => $this->address,
            'company' => new CompanyResource($this->companies)   
        ];
    }
}
