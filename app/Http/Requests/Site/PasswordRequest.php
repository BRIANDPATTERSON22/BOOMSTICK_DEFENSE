<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest {
    //
    public function rules()
    {
        return [
            'email' => 'required|email',
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Fill the email address',
            'password.required' => 'Fill the password',
            'old_password.required' => 'Fill the old password',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
