<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'required|max:250',
            'slug' => 'unique:events,slug,'.$this->segment(3),
            'date' => 'date|required',
            'venue' => 'required',
            'image' => 'mimes:jpeg,jpg,png',
            'summary' => 'required|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Fill the title',
            'slug.required'  => 'Fill the slug/URL',
            'slug.unique'  => 'The event has already been taken',
            'date.required'  => 'Fill the event date',
            'venue.required'  => 'Fill the event venue',
            'summary.required'  => 'Fill short description of the event',
        ];
    }

    public function authorize()
    {
        return true;
    }
}