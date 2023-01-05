<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ProductCategorySub extends Authenticatable
{
    protected $table = 'products_category_sub';
    protected $fillable = ['category_id', 'name', 'slug', 'image', 'description', 'is_firearm', 'is_age_verification_required', 'status'];

    public function mainCategory()
    {
        return $this->belongsTo('App\ProductCategory', 'category_id');
    }

    public function products()
    {
        return $this->hasMany('App\Product', 'category_id');
    }
}
