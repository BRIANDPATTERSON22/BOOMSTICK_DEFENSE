<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'required|max:250',
            // 'time' => 'required|max:250',
            // 'amount' => 'required|numeric|min:0',
            // 'global_tax_percentage' => 'required|numeric|min:0',
            // 'uk_amount' => 'required|numeric|min:0',
            // 'uk_tax_percentage' => 'required|numeric|min:0',
            // 'european_amount' => 'required|numeric|min:0',
            // 'european_tax_percentage' => 'required|numeric|min:0',
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