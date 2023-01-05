<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreManagerRequest extends FormRequest {

    public function rules()
    {
        return [
            'first_name' => 'required|max:250',
            'last_name' => 'required|max:250',
            'email' => 'required|email|unique:store_managers,email,'.$this->segment(3),
            'slug' => 'unique:store_managers,slug,'.$this->segment(3),
            'password' => 'nullable|min:8',
            // 'password' => 'sometimes|required',
            // 'address_1' => 'required',
            'image' => 'mimes:jpeg,jpg,png',
            // 'mobile_no' => 'required|regex:/^\+?[^a-zA-Z]{9,}$/',
            // 'phone_no' => 'nullable|regex:/^\+?[^a-zA-Z]{9,}$/',
            'stores' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'first_name.required' => 'Fill the title',
            'last_name.required' => 'Fill the title',
            'email.unique'  => 'The Email has already been taken',
            'slug.unique'  => 'The slug has already been taken',
        ];
    }

    public function authorize()
    {
        return true;
    }
}