<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'name' => $this->name
           // 'cnpj' => $this->cnpj,
            // 'cep' => $this->cep,
            // 'address'=> $this->address,
            // 'complement'=> $this->complement,
            // 'website'=> $this->website,
            // 'email'=> $this->email,
            // 'phone_number'=> $this->phone_number,
            // 'responsible'=> $this->responsible
        ];
    }
}
