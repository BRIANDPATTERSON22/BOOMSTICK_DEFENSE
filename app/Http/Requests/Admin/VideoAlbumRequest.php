<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VideoAlbumRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'required|max:250',
            'slug' => 'unique:videos_album,slug,'.$this->segment(4),
            'description' => 'max:1000',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Fill the title',
            'slug.required' => 'Fill the slug/URL',
            'slug.unique'  => 'The video album has already been taken',
        ];
    }

    public function authorize()
    {
        return true;
    }
}