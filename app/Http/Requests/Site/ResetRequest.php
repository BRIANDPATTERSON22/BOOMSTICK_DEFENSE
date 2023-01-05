<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class ResetRequest extends FormRequest {
    //
    public function rules()
    {
        return [
            'password' => 'required|confirmed|min:6',
        ];
    }


    public function messages()
    {
        return [
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
