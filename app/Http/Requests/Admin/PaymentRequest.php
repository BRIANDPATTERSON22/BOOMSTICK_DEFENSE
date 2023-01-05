<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'required|max:250',
        ];

    }

    public function messages()
    {
        return [

        ];
    }

    public function authorize()
    {
        return true;
    }
}