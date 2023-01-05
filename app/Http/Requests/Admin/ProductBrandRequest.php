<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductBrandRequest extends FormRequest {

    public function rules()
    {
        return [
            'name' => 'required|max:250',
            'slug' => 'unique:products_brand,slug,'.$this->segment(3),
            'image' => 'mimes:jpeg,jpg,png',
        ];

    }

    public function messages()
    {
        return [
            'name.required' => 'Fill the brand name',
            'slug.required'  => 'Fill the slug/URL',
            'slug.unique'  => 'The Product brand has already been taken',
        ];
    }

    public function authorize()
    {
        return true;
    }
}