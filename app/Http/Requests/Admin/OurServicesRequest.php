<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OurServicesRequest extends FormRequest {

    public function rules()
    {
        return [
            'service_name' => 'required|max:250',
            'description' => 'required|max:250',
            'image' => 'mimes:jpeg,jpg,png',
        ];

    }

    public function messages()
    {
        return [
            'service_name.required' => 'Fill the title',
            'description.required' => 'Fill the title',
            'image.required'  => 'Select brand images',
        ];
    }

    public function authorize()
    {
        return true;
    }
}