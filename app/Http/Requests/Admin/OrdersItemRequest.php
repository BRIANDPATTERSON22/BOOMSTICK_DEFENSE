<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OrdersItemRequest extends FormRequest {

    public function rules()
    {
        return [
            // 'first_name' => 'required|max:250',
            // 'last_name' => 'required|max:250',
            // 'postal_code' => 'required',
            // 'email' => 'required|unique:customers,email,'.$this->segment(3),
            // 'mobile' => 'required|regex:/^\+?[^a-zA-Z]{9,}$/',
            // 'phone' => 'nullable|regex:/^\+?[^a-zA-Z]{9,}$/',
            // 'image' => 'mimes:jpeg,jpg,png',
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