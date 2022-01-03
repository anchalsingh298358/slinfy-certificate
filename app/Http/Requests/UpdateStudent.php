<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudent extends FormRequest
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
            'date' => 'required',
            'name' => 'required',
            'email' => ['required',Rule::unique('users')->ignore(request()->id)->whereNull('deleted_at')],
            'country_code' => 'required',
            'phone_number' => ['required',Rule::unique('users')->ignore(request()->id)->whereNull('deleted_at')],
            'father_name' => 'required',
            'mother_name' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'course' => 'required',
            'date_from' => 'required',
            'date_to' => 'required|after:date_from',
            'department' => 'required',
            'college_name' => 'required',
            'session' => 'required',
        ];
    }
}
