<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest {

    public function rules()
    {
        return [
            'name' => 'required|max:250',
            'title' => 'max:250',
            'favicon' => 'mimes:jpeg,jpg,png',
            'logo' => 'mimes:jpeg,jpg,png',
            'keywords' => 'max:500',
            'description' => 'max:1000',
            'email' => 'required|email',
            'phone_no' => 'nullable|regex:/^\+?[^a-zA-Z]{9,}$/',
            'mobile_no' => 'nullable|regex:/^\+?[^a-zA-Z]{9,}$/',
            'fax_no' => 'nullable|regex:/^\+?[^a-zA-Z]{9,}$/',
            'address' => 'max:300',
            'branch' => 'max:300',
            'google_analytics' => 'max:20',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Fill the site name',
            'email.required'  => 'Fill the email address',
        ];
    }

    public function authorize()
    {
        return true;
    }
}