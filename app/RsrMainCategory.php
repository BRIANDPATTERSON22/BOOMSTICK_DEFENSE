<?php namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class RsrMainCategory extends Authenticatable
{
    protected $table = 'rsr_products_categories';
    protected $fillable = ['department_id', 'department_name', 'category_id', 'category_name', 'title', 'slug', 'image', 'banner_image', 'color', 'description', 'is_enabled_on_menu', 'menu_order_no', 'status', 'retail_price_percentage'];

    public function rsr_sub_categories()
    {
        return $this->hasMany('App\RsrSubCategory', 'department_id', 'department_id')->groupBy('value');
    }

    public function related_products_by_main_category($rsrStockNumber, $categoryId)
    {
        return RsrProductXref::where('rsr_stock_number', $rsrStockNumber)->where('associated_department_number', $categoryId)->get();
    }

    // public function rsr_sub_categories_from_attributes()
    // {
    //     return $this->hasMany('App\RsrProducAttribute', 'department_id', 'department_id')->groupBy('sub_category');
    // }

    public function rsr_main_category_attribute()
    {
        return $this->belongsTo('App\RsrMainCategoryAttributes', 'department_id', 'department_id');
    }
}
