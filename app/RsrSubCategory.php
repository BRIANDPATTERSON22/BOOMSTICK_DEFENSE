<?php namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class RsrSubCategory extends Authenticatable
{
    protected $table = 'rsr_products_subcategories';
    protected $fillable = ['rsr_stock_number', 'code', 'value', 'department_id'];

    public function have_rsr_main_category()
    {
        return $this->belongsTo('App\RsrMainCategory', 'department_id');
    }
    
}
