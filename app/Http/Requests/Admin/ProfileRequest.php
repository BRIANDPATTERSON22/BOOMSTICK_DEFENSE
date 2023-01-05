<?php namespace App\Http\Requests\Admin;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest {

    public function rules()
    {
        $loginUser = Auth::user();

        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$loginUser->id,
            'image' => 'mimes:jpeg,jpg,png',
            'password' => 'required|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Fill the name',
            'email.required'  => 'Fill the email address',
            'email.unique'  => 'The email has already been taken',
            'password.required'  => 'Fill the password',
        ];
    }

    public function authorize()
    {
        return true;
    }
}