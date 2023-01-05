<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest {
    //
    public function rules()
    {
        return [
            'first_name' => 'required|max:250',
            'last_name' => 'required|max:250',
            'address1' => 'required|max:250',
            'city' => 'required',
            // 'country_id' => 'required',
            'billing_country_id' => 'required',
            'mobile' => 'required|regex:/^\+?[^a-zA-Z]{9,}$/',
            'email' => 'nullable|email',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
