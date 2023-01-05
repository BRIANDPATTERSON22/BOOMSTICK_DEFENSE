<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'required|max:250',
            'url' => 'required|max:250',
            'image' => 'mimes:jpeg,jpg,png',
            'slug' => 'unique:companies,slug,'.$this->segment(3),
        ];

    }

    public function messages()
    {
        return [
            'title.required' => 'Fill the title',
            'url.required' => 'Fill the title',
            'image.required'  => 'Select brand images',
            'slug.unique'  => 'The event has already been taken',
        ];
    }

    public function authorize()
    {
        return true;
    }
}