<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'required|max:250',
            'slug' => 'unique:videos,slug,'.$this->segment(3),
            'album_id' => 'required',
            'source' => 'required',
            'content' => 'max:10000',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Fill the title',
            'slug.required' => 'Fill the slug/URL',
            'slug.unique' => 'The video has already been taken',
            'album_id.required' => 'Select a video album',
        ];
    }

    public function authorize()
    {
        return true;
    }
}