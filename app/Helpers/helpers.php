<?php 

	function shipping_vat_amount()
	{
		$shippingVat = number_format(session('shipping_amount') / 1.2 * 0.2, 2);
		return $shippingVat;
	}

	function shipping_amount()
	{
		$shippingAmount = session('shipping_amount');
		return $shippingAmount;
	}

	function auth_customer()
	{
		$customer = Auth::user()->customer;
		return $customer;
	}

	function customer_country()
	{
		$customerCountry = strtolower(auth_customer()->is_same_as_billing == 1 ? auth_customer()->billingCountry->iso : auth_customer()->deliveryCountry->iso);
		return $customerCountry;
	}

	function is_europian_customer()
	{
		$isEuropianCustomer = in_array(strtolower(auth_customer()->is_same_as_billing == 1 ? auth_customer()->billingCountry->iso : auth_customer()->deliveryCountry->iso), config('default.european_countries_iso'));
		return $isEuropianCustomer;
	}

	function is_uk_customer()
	{
		$isUkCustomer = in_array(strtolower(auth_customer()->is_same_as_billing == 1 ? auth_customer()->billingCountry->iso : auth_customer()->deliveryCountry->iso), config('default.uk_countries_iso'));
		return $isUkCustomer;
	}

	function get_main_category_name($id)
	{
		if (App\RsrMainCategory::where('department_id', $id)->first()) {
			return App\RsrMainCategory::where('department_id', $id)->first()->category_name;
		}else{
			return request()->slug;
		}
	}

	function slug_to_word($slugdedWord)
	{
		return str_replace('_', ' ',ucwords($slugdedWord, '_'));
	}







