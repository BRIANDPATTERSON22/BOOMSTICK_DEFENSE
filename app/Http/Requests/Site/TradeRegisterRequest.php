<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class TradeRegisterRequest extends FormRequest {
    //
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required|phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            "g-recaptcha-response" => \App::environment('local') ? '' : 'required|recaptcha',
            "terms_and_conditions" => 'required',
            "company_name" => 'required',
            
            'address1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'billing_country_id' => 'required',
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
            
            'address1.required' => 'Please enter billing address',
            'city.required' => 'Please enter billing city',
            'state.required' => 'Please enter billing county',
            'postal_code.required' => 'Please enter billing postal code',
            'billing_country_id.required' => 'Please enter billing country',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
