<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest {

    public function rules()
    {
        return [
            'password' => 'min:6|confirmed|required',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Fill the password',
        ];
    }

    public function authorize()
    {
        return true;
    }
}