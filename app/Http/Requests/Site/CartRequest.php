<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest {
    //
    public function rules()
    {
        return [
            // 'color_id' => 'required',
            // 'store_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            // 'color_id.required' => 'Select Color',
            // 'store_id.required' => 'Please select a store',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
