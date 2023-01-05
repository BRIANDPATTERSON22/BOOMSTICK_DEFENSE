<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'required|min:10',
            'slug' => 'unique:blogs,slug,'.$this->segment(3),
            'category_id' => 'required',
            'image' => 'mimes:jpeg,jpg,png',
            'summary' => 'required',
            'content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Please select a Blog category',
            // 'summary.max' => 'Please select a Blog category',
        ];
    }

    public function authorize()
    {
        return true;
    }
}