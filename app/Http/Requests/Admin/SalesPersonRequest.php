<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SalesPersonRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'required|max:250',
            'slug' => 'unique:sales_person,slug,'.$this->segment(3),
            'email' => 'required|email|unique:sales_person,email,'.$this->segment(3),
            // 'email' => 'required|email|unique:users,email,'.$this->segment(3),
            'image' => 'mimes:jpeg,jpg,png',
            // 'brands' => 'required',
            'stores' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'title.required' => 'Fill the brand name',
            'slug.required'  => 'Fill the slug/URL',
            'slug.unique'  => 'The sales person has already been taken',
            // 'brands.required'  => 'Select the brands for the sales person',
            'stores.required'  => 'Select the stores for the sales person',
        ];
    }

    public function authorize()
    {
        return true;
    }
}