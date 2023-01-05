<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OccasionProductRequest extends FormRequest {

    public function rules()
    {
        return [
            // 'name' => 'required|max:250',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'product_id' => 'required',
            'slug' => 'unique:products_category_sub,slug,'.$this->segment(3),
            // 'description' => 'max:1000',
        ];
    }

    public function messages()
    {
        return [
            // 'name.required' => 'Fill the Category Name',
            'slug.required'  => 'Fill the slug/URL',
            'slug.unique'  => 'The Product category has already been taken',
        ];
    }

    public function authorize()
    {
        return true;
    }
}