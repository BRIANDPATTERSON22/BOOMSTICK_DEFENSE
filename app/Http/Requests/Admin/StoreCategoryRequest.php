<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'required|max:250',
            'slug' => 'unique:store_categories,slug,'.$this->segment(3),
            'image' => 'mimes:jpeg,jpg,png',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Fill the title',
            'slug.required'  => 'Fill the slug/URL',
            'slug.unique'  => 'The event has already been taken',
        ];
    }

    public function authorize()
    {
        return true;
    }
}