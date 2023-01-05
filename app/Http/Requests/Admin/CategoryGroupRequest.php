<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryGroupRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'required|max:250',
            'slug' => 'unique:category-groups,slug,'.$this->segment(3),
            'is_enabled_on_menu' => 'required',
            'menu_order_no' => 'required',
            'description' => 'max:1000',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Fill the group title',
            'slug.required'  => 'Fill the slug/URL',
            'slug.unique'  => 'The Product category has already been taken',
        ];
    }

    public function authorize()
    {
        return true;
    }
}