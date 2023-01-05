<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest {
    //
    public function rules()
    {
        return [
            'login_email' => 'required|email',
            'login_pass' => 'required',
            "g-recaptcha-response" => \App::environment('local') ? '' : 'required|recaptcha',
        ];
    }

    public function messages()
    {
        return [
            'login_pass.required' => 'Please enter your password',
            'login_email.required' => 'Please enter your email',
            'g-recaptcha-response.required'  => 'Fill the Google ReCaptcha',
        ];
    }

    public function authorize()
    {
        return true;
    }
}