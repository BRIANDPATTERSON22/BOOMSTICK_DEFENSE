<?php namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ProductCategoryType extends Authenticatable
{
    protected $table = 'products_category_type';
    protected $fillable = ['name', 'description', 'slug', 'image', 'status','sub_category_id'];

    public function mainCategory()
    {
        return $this->belongsTo('App\ProductCategory', 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo('App\ProductCategorySub', 'sub_category_id');
    }

    public function products()
    {
        return $this->hasMany('App\Product', 'category_id');
    }
}
