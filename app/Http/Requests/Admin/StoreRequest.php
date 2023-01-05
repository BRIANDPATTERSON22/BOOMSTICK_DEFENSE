<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'required|max:250',
            'slug' => 'unique:stores,slug,'.$this->segment(3),
            // 'division' => 'required',
            'store_category_id' => 'required',
            'banner' => 'required',
            'legacy' => 'required|numeric',
            'store_id' => 'required|numeric',
             // 'address_1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'phone_no' => 'required',
            'image' => 'mimes:jpeg,jpg,png',
            // 'special_price' => 'nullable|numeric|min:0',
            // 'quantity' => 'required|numeric|min:0',
            // 'weight' => 'nullable|numeric|min:0',
            // 'category_main_id' => 'required',
            // 'type_id' => 'required',
            // 'summary' => 'max:1000',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Enter the store name',
        ];
    }

    public function authorize()
    {
        return true;
    }
}