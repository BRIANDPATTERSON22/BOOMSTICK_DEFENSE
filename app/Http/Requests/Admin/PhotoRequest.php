<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest {

    public function rules()
    {
        return [
            'photoAlbum.title' => 'required|max:250',
            'photoAlbum.slug' => 'unique:photos_album,slug,'.$this->segment(3),
            'photoAlbum.content' => 'max:1000',
            'photo.image' => 'array',
        ];

    }

    public function messages()
    {
        return [
            'photoAlbum.title.required' => 'Fill the title',
            'photoAlbum.slug.required'  => 'Fill the display area',
            'photoAlbum.slug.unique'  => 'The photo album has already been taken',
            'photo.image.required'  => 'Select album images',
        ];
    }

    public function authorize()
    {
        return true;
    }
}