<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlockRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'required|max:200',
            'slug' => 'required|unique:blocks,slug,'.$this->segment(3),
        ];
    }

    public function authorize()
    {
        return true;
    }
}