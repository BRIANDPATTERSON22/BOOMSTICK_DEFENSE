<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ThemeSettings extends Authenticatable
{
    protected $table = 'theme_settings';
    protected $fillable = ['top_bar_color', 'logo_size', 'logo_background_color', 'logo_background_block_color', 'search_bgc', 'search_bgc', 'search_box_shape', 'social_media_bgc', 'main_menu_bgc', 'main_menu_font_color','main_menu_type', 'social_media_border_color', 'logo_block_border_color', 'tool_bar_color', 'tool_bar_border_color', 'top_bar_botom', 'main_menu_active_font_color', 'is_active_social_media', 'featured_products_title', 'featured_products_title_color', 'limited_time_offer_title', 'limited_time_offer_title_color', 'staff_picks_title','staff_picks_title_color','popular_brands_title','popular_brands_title_color','first_footer_column','second_footer_column','third_footer_column','fourth_footer_column','is_active_shopping','section_display_type','carosel_category', 'footer_background'];
}
