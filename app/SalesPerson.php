<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesPerson extends Model
{
    protected $table = 'sales_person';
    protected $fillable = ['user_id', 'title', 'slug', 'image', 'email', 'phone_no','description', 'status'];

    public function haveBrands()
    {
        return $this->hasMany('App\BrandSalesPerson', 'sales_person_id');
    }

    public function haveStores()
    {
        return $this->hasMany('App\SalesPersonHasStore', 'sales_person_id');
    }

    // public function subCategoryType()
    // {
    // 	 return $this->hasMany('App\Product', 'brand_id');
    // }

}
