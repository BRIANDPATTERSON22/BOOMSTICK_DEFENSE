<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ProductYearMakeModel extends Authenticatable
{
    protected $table = 'products_year_make_model';
    protected $fillable = ['product_id', 'year_make_model', 'year_make_model_full', 'part_number', 'year', 'year_1', 'year_2', 'year_range', 'make','model'];

    public function products()
    {
        return $this->hasMany('App\Product', 'product_id');
    }
}
