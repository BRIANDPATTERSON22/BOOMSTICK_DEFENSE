<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {

    public function rules()
    {
        return [
            'name' => 'required|max:250',
            'roles_id' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->segment(3),
            'password' => 'min:6|confirmed|required_if:id,'.$this->segment(3),
            'image' => 'mimes:jpeg,jpg,png',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Fill the name',
            'roles_id.required' => 'Select a user role',
            'email.required' => 'Fill the email address',
            'email.unique' => 'The email has already been taken',
            'password.required_if' => 'Fill the password',
        ];
    }

    public function authorize()
    {
        return true;
    }
}