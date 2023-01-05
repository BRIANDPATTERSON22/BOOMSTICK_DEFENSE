<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest {

    public function rules()
    {
        return [
            'name' => 'required|unique:roles,name,'.$this->segment(3),
            'guard_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Fill the role name',
            'name.unique'  => 'The role has already been taken',
            'guard_name.required'  => 'Fill the guard name',
        ];
    }

    public function authorize()
    {
        return true;
    }
}