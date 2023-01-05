<?php namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ProductCategory extends Authenticatable
{
    protected $table = 'products_category';
    protected $fillable = ['name', 'description', 'slug', 'image', 'status', 'is_enabled_on_menu', 'menu_order_no', 'type_id', 'retail_price_percentage'];

    public function subCategories()
    {
        return $this->hasMany('App\ProductCategorySub', 'category_id')->where('status', 1);
    }
}
