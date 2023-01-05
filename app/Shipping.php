<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $table = 'shippings';
    protected $fillable = ['title', 'time', 'european_amount', 'uk_amount', 'amount', 'description', 'status','european_tax_percentage','uk_tax_percentage', 'is_not_uk_available','global_tax_percentage', 'is_checked_uk', 'is_checked_europe', 'is_checked_global', 'global_amount', 'global_tax_percentage', 'is_not_globally_available', 'austria_amount', 'austria_tax_percentage', 'is_not_austria_available', 'belgium_amount', 'belgium_tax_percentage', 'is_not_belgium_available', 'bulgaria_amount','bulgaria_tax_percentage', 'is_not_bulgaria_available', 'croatia_amount', 'croatia_tax_percentage', 'is_not_croatia_available', 'republic_of_cyprus_amount', 'republic_of_cyprus_tax_percentage', 'is_not_republic_of_cyprus_available', 'czech_republic_amount', 'czech_republic_tax_percentage', 'is_not_czech_republic_available', 'denmark_amount', 'denmark_tax_percentage', 'is_not_denmark_available', 'estonia_amount', 'estonia_tax_percentage', 'is_not_estonia_available', 'finland_amount', 'finland_tax_percentage', 'is_not_finland_available', 'france_amount', 'france_tax_percentage', 'is_not_france_available', 'germany_amount', 'germany_tax_percentage', 'is_not_germany_available', 'greece_amount', 'greece_tax_percentage', 'is_not_greece_available', 'hungary_amount', 'hungary_tax_percentage', 'is_not_hungary_available', 'ireland_amount', 'ireland_tax_percentage', 'is_not_ireland_available', 'italy_amount', 'italy_tax_percentage', 'is_not_italy_available', 'latvia_amount', 'latvia_tax_percentage', 'is_not_latvia_available', 'lithuania_amount', 'lithuania_tax_percentage', 'is_not_lithuania_available', 'luxembourg_amount', 'luxembourg_tax_percentage', 'is_not_luxembourg_available', 'malta_amount', 'malta_tax_percentage', 'is_not_malta_available', 'netherlands_amount', 'netherlands_tax_percentage', 'is_not_netherlands_available', 'poland_amount', 'poland_tax_percentage', 'is_not_poland_available', 'portugal_amount', 'portugal_tax_percentage', 'is_not_portugal_available', 'romania_amount', 'romania_tax_percentage', 'is_not_romania_available', 'slovakia_amount', 'slovakia_tax_percentage', 'is_not_slovakia_available', 'slovenia_amount', 'slovenia_tax_percentage', 'is_not_slovenia_available', 'spain_amount', 'spain_tax_percentage', 'is_not_spain_available', 'sweden_amount', 'sweden_tax_percentage', 'is_not_sweden_available', 'uk_alpha_2_code', 'is_checked_normal_customers', 'is_checked_cake_time_club_customers', 'is_checked_trade_customers', 'customer_type', 'is_free_shipping'];	
}