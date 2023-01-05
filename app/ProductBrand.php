<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    protected $table = 'products_brand';
    protected $fillable = ['sales_person_id', 'name', 'slug', 'image', 'description', 'status'];

    public function products()
    {
        return $this->hasMany('App\Product', 'brand_id');
    }

    public function subCategoryType()
    {
    	 return $this->hasMany('App\Product', 'brand_id');
    }

    public function salesPersonSingle()
    {
        return $this->belongsTo('App\SalesPerson', 'sales_person_id');
    }
}
