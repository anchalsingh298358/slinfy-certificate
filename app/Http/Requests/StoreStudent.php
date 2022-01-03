<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudent extends FormRequest
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
            'name' => 'required',
            'email' => 'required|unique:users,email,NULL,id,deleted_at,NULL',
            'country_code' => 'required',
            'phone_number' => 'required|unique:users,phone_number,NULL,id,deleted_at,NULL',
            'father_name' => 'required',
            'mother_name' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'technology' => 'required',
            'date_from' => 'required',
            'date_to' => 'required|after:date_from',
            'duration' => 'required',
            'college_name' => 'required',
            'session' => 'required',
        ];
    }
}
