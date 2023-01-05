<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest {
    //
    public function rules()
    {
        return [
            'name' => 'required|max:250',
            'email' => 'required|email',
            'phone' => 'regex:/^\+?[^a-zA-Z]{5,}$/',
            'review_title' => 'required',
            'review' => 'required|min:10|max:1000',
            'star' => 'required',
            //'g-recaptcha-response' => 'required|recaptcha',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Fill the Name',
            'email.required'  => 'Fill the Email Address',
            'review.required'  => 'Fill the Review',
            'star.required'  => 'Give a Star Rating',
            'g-recaptcha-response.required'  => 'Fill the Google ReCaptcha',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
