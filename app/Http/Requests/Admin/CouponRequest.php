<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest {
    //
    public function rules()
    {
        return [
            'name' => 'required',
            'series_no' => 'required|min:3',
            'pin_no' => 'required|min:3',
            'percentage' => 'required|numeric|min:0',
            'count' => 'required|numeric|min:0',
            'expiry_date' => 'required|date',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
