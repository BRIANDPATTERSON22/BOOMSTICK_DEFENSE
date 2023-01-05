<?php namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class OccasionProduct extends Authenticatable
{
    protected $table = 'occasion_products';
    protected $fillable = ['name', 'description', 'slug', 'image', 'status','category_id','product_id','sub_category_id'];

    public function subCategories()
    {
        return $this->hasMany('App\ProductCategorySub', 'category_id');
    }
    public function category()
    {
        return $this->belongsTo('App\ProductCategory', 'category_id');
    }
    public function subCategory()
    {
        return $this->belongsTo('App\ProductCategorySub', 'sub_category_id');
    }
    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
