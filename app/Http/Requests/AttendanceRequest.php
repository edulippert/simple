<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
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
        return [
            'attendance_place' => 'required',
            'call_date' => 'required',
            'inspection_date' => '',
            'finish_date' => '',
            'description' => 'required',
            'solution' => '',
            'responsible'=> '',
            'manpower_cost'=> '',
            'material_cost'=> '',
            'total_cost'=> '',
            'contact_name'=> 'required',
            'contact_email'=> '',
            'contact_phone_number'=> 'required',
            'condominium_id' => 'required',
            'company_id' => 'required'
        ];
    }
}
