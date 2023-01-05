<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class CheckoutAddresRequest extends FormRequest {
    //
    public function rules()
    {
        // if(Auth::user()->customer->is_same_as_billing == 0)
        //     return [
        //         'first_name' => 'required',
        //         'last_name' => 'required',
        //         'address1' => 'required',
        //         'city' => 'required',
        //         'postal_code' => 'required',
        //         'billing_country_id' => 'required',
        //         'mobile' => 'required|regex:/^\+?[^a-zA-Z]{9,}$/',
        //         'email' => 'required|email',
        //         'address2' => 'required',
        //         'delivery_city' => 'required',
        //         'delivery_state' => 'required',
        //         'delivery_postel_code' => 'required',
        //         'delivery_country_id' => 'required',
        //     ];
        // else{
            return [
                'first_name' => 'required',
                'last_name' => 'required',
                'billing_address' => 'required',
                'billing_city' => 'required',
                'billing_postal_code' => 'required',
                'billing_country_id' => 'required',
                'billing_state' => 'required',
                'phone_no' => 'required|regex:/^\+?[^a-zA-Z]{9,}$/',
                'email' => 'required|email',
            ];
        // }
    }

    public function authorize()
    {
        return true;
    }
}