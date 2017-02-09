<?php

namespace EverestBill\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationData extends FormRequest
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
            'full_name'             => ['required', 'min:3', 'max:64', 'Regex:/^[A-Za-z ]+$/'],
            'email'                 => 'required|email',
            'password'              => 'required|min:5|max:32|same:password_confirmation',
            'password_confirmation' => 'required'
        ];
    }
}
