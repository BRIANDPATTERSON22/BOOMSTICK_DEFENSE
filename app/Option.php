<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
	protected $table = 'options';

	protected $casts = [ 'theme_settings' => 'array'];

    protected $fillable = ['name', 'title', 'description', 'keywords', 'email', 'phone_no', 'mobile_no', 'whatsapp_no', 'viber_no', 'fax_no', 'address', 'address_1', 'branch', 'branch_1', 'map_iframe', 'latitude', 'longitude', 'favicon', 'logo', 'logo_white', 'logo_black', 'bg_breadcrumb','facebook','twitter','instagram','youtube','pinterest','linkedin','google_analytics', 'company_name','company_website', 'currency', 'currency_code', 'currency_symbol', 'is_sidebar_collapsed', 'sidebar_skin_color', 'theme_style_sheet', 'custom_css_style', 'theme_settings', 'disclaimer_agreement_message', 'warning_message', 'status', 'skype_id', 'retail_price_percentage', 'is_display_bs_products', 'retail_price_percentage'];
}
