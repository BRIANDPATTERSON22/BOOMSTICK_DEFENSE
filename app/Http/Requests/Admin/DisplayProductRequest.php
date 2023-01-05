<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DisplayProductRequest extends FormRequest {

    public function rules()
    {
        return [
            'type' => 'required',
            'products' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'type.required' => 'Select the display type',
            'products.required'  => 'Select the products',
        ];
    }

    public function authorize()
    {
        return true;
    }
}