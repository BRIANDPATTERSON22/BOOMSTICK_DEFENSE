<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SectionOfferRequest extends FormRequest {

    public function rules()
    {
        return [
            // 'name' => 'required|max:250',

        ];
    }

    public function messages()
    {
        return [
            // 'name.required' => 'Fill the site name',
        ];
    }

    public function authorize()
    {
        return true;
    }
}