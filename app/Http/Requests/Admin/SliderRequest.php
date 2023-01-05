<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'max:250',
            'image' => 'mimes:jpeg,jpg,png',
        ];
    }

    public function authorize()
    {
        return true;
    }
}