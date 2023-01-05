<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdsRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'required|max:250',
            'display' => 'required',
            'content' => 'max:1000',
            // 'image' => 'required|mimes:jpeg,jpg,png,gif',
            'image' => 'mimes:jpeg,jpg,png,gif',
            // 'end_at' => 'date|required',
            // 'link' => 'nullable|url|max:250',
            'link' => 'nullable|max:250',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Fill the title',
            'display.required'  => 'Fill the display area',
            // 'image.required'  => 'Select the advertisement image',
        ];
    }

    public function authorize()
    {
        return true;
    }
}