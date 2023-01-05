<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest {

    public function rules()
    {
        return [
            'title' => 'required|max:250',
            'product_id' => 'required',
            'slug' => 'unique:products,slug,'.$this->segment(3),
            'upc' => 'required',
            'quantity' => 'required|numeric|min:0',
            // 'price' => 'required|numeric|min:0',
            'retail_price' => 'required|numeric|min:0',
            // 'sale_price' => 'required|numeric|min:0',
            'brand_id' => 'required',
            // 'short_description' => 'required',
            'content' => 'required',
            // 'category_id' => 'required',
            'category_main_id' => 'required',
            'offer_started_at' => 'nullable|date',
            'offer_ended_at' => 'nullable|date',
            'available_at' => 'nullable|date',
            // 'stores' => 'required',
            // 'description' => 'required',
            // 'special_price' => 'nullable|numeric|min:0',
            // 'weight' => 'nullable|numeric|min:0',
            // 'type_id' => 'required',
            // 'image' => 'mimes:jpeg,jpg,png',
            // 'brand_id' => 'required',
            // 'vat' => 'required',
           // 'discount_percentage' => 'required',
            'manufacturer_id' => 'required',
            'full_manufacturer_name' => 'required',
            'manufacturer_part_number' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Fill the produce name',
        ];
    }

    public function authorize()
    {
        return true;
    }
}