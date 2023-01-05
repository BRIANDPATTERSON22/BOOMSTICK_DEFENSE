<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class ForgetRequest extends FormRequest {
    //
    public function rules()
    {
        return [
            'email' => 'required|email',
            "g-recaptcha-response" => \App::environment('local') ? '' : 'required|recaptcha',
        ];
    }


    public function messages()
    {
        return [
            'email.required' => 'Fill the login email address',
            'g-recaptcha-response.required'  => 'Fill the Google ReCaptcha',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
