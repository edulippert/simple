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
            'inspection_date' => 'required',
            'finish_date' => 'required',
            'description' => 'required',
            'solution' => 'required',
            'responsible'=> 'required',
            'manpower_cost'=> 'required',
            'material_cost'=> 'required',
            'total_cost'=> 'required',
            'contact_name'=> 'required',
            'contact_email'=> 'required',
            'contact_phone_number'=> 'required',
            'condominium_id' => 'required'
        ];
    }
}
