<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerGuaranteeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $group_id = $this->group_id;
        $item_id = $this->item_id;
        $condominium_id = $this->condominium_id;
        $messages = [
            'customer_guarantees.item_id.unique' => 'Given ip and hostname are not unique',
        ];

        return [
            'starts_date' => 'required',
            'due_date' => 'required',
            'item_id' => [
                'required',
                Rule::unique('customer_guarantees')->where(function ($query) use ($group_id,$item_id,$condominium_id){
                    return $query
                        ->whereGroupId($group_id)
                        ->whereItemId($item_id)
                        ->whereCondominiumId($condominium_id);
                }),
            ],$messages
        ];
    }
}
