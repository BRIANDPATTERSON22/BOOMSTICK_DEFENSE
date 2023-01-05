<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'required|max:250',
            'slug' => 'unique:pages,slug,'.$this->segment(3),
            'image' => 'mimes:jpeg,jpg,png',
            'summary' => 'max:1000',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Fill the title',
            'slug.required'  => 'Fill the slug/URL',
            'slug.unique'  => 'The page has already been taken',
        ];
    }

    public function authorize()
    {
        return true;
    }
}