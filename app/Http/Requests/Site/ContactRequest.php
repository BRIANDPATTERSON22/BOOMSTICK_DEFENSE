<?php namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest {

    public function rules()
    {
        return [
            'contact_reason' => 'required',
            'first_name' => 'required|max:250',
            'email' => 'required|email',
            'phone_no' => 'regex:/^\+?[^a-zA-Z]{5,}$/',
            // 'subject' => 'required|max:250',
            'inquiry' => 'required|max:1000',
            "g-recaptcha-response" => \App::environment('local') ? '' : 'required|recaptcha',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Please enter your first name',
            'inquiry.required'  => 'Please enter your Message',
            'phone.required'  => 'Please enter your contact number',
            'phone.regex'  => 'Please enter your contact number',
            'email.required'  => 'Please enter your Email',
            'subject.required'  => 'Please enter the subject',
            'contact_reason.required'  => 'Please select the conatct reason',
            'g-recaptcha-response.required' => 'Please fill reCAPTCHA to continue',
        ];
    }

    public function authorize()
    {
        return true;
    }
}