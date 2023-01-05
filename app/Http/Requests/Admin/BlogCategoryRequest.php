<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'required|min:3',
            'slug' => 'required|unique:blog_category,slug,'.$this->segment(4),
            'description' => 'max:1000',
        ];
    }

    public function authorize()
    {
        return true;
    }
}