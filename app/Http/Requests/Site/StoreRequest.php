<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest {
    //
    public function rules()
    {
        return [
            'search_text' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'search_text.required' => 'Please enter the search term (division, zip, state, )',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
