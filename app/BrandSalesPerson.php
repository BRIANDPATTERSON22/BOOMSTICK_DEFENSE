<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandSalesPerson extends Model
{
    protected $table = 'brand_sales_person';
    protected $fillable = ['brand_id', 'sales_person_id'];

    public function brand()
    {
        return $this->belongsTo('App\ProductBrand', 'brand_id');
    }

    // public function products()
    // {
    //     return $this->hasMany('App\Product', 'brand_id');
    // }

    // public function subCategoryType()
    // {
    // 	 return $this->hasMany('App\Product', 'brand_id');
    // }

}
