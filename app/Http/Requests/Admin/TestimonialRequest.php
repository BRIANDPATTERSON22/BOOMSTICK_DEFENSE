<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest {
    //
    public function rules()
    {
        return [
            // 'title' => 'required|min:3',
            'first_name' => 'required|min:3',
            // 'last_name' => 'required|min:3',
            'job' => 'required|min:3',
            'review' => 'required|min:3',
            'slug' => 'unique:testimonial,slug,'.$this->segment(3),
            'image' => 'mimes:jpeg,jpg,png',
            'summary' => 'max:1000',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
