<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HomeSliderRequest extends FormRequest {

    public function rules()
    {
        return [
            // 'title' => 'required|min:3',
            // 'slug' => 'required|unique:testimonials,slug,'.$this->segment(3),
            // 'date' => 'date|required',
            // 'venue' => 'required',
            // 'image' => 'mimes:jpeg,jpg,png',
            // 'summary' => 'required|max:500',
            'image' => 'mimes:jpeg,jpg,png|max:1000',
        ];
    }
    
    public function messages()
    {
        return [
            // 'image.dimensions' => 'Wrong image dimention. dimention should be [width: 1920 x height :1080] ',
            'image.max' => 'The image may not be greater than 1000 kilobytes! Image size should be equal to or less than 1000KB = 1MB ',
        ];
    }

    public function authorize()
    {
        return true;
    }
}