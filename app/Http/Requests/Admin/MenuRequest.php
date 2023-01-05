<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'required',
            'url' => 'required|unique_with:menus,type,'.$this->segment(3),
            'type' => 'required',
            'order' => 'nullable|numeric'
            ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Fill the title',
            'slug.required'  => 'Fill the slug/URL',
            'slug.unique'  => 'The menu has already been taken',
            'type.required'  => 'Fill the menu type',
        ];
    }

    public function authorize()
    {
        return true;
    }
}