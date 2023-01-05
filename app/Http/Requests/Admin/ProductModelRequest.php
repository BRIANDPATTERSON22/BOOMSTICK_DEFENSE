<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductModelRequest extends FormRequest {

    public function rules()
    {
        return [
            'name' => 'required|max:250',
            'slug' => 'unique:products_model,slug,'.$this->segment(3),
            'image' => 'mimes:jpeg,jpg,png',
        ];

    }

    public function messages()
    {
        return [
            'name.required' => 'Fill the model',
            'slug.required'  => 'Fill the slug/URL',
            'slug.unique'  => 'The Product model has already been taken',
        ];
    }

    public function authorize()
    {
        return true;
    }
}