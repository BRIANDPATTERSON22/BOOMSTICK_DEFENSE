<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest {
    //
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_no' => 'required',
            // 'mobile' => 'required|phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            "g-recaptcha-response" => \App::environment('local') ? '' : 'required|recaptcha',
            "terms_and_conditions" => 'required',
        ];
    }


    public function messages()
    {
        return [
            'first_name.required' => 'Please enter your first name',
            'last_name.required' => 'Please enter your last name',
            'mobile.required' => 'Please enter your contact number',
            'mobile.phone' => 'Please enter your contact number',
            'email.required' => 'Please enter your email',
            'email.unique' => 'The email address you have entered is already registered',
            'g-recaptcha-response.required' => 'Please fill reCAPTCHA to continue',
            'terms_and_conditions.required' => 'Please agree to the terms & conditions',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
