<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreProduct extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'store_products';
    protected $fillable = ['store_id', 'product_id', 'status'];

     public function user()
     {
         return $this->belongsTo('App\User', 'user_id');
     }

     public function product()
     {
         return $this->belongsTo('App\Product', 'product_id');
     }

     public function store()
     {
         return $this->belongsTo('App\Store', 'store_id', 'store_id');
     }

     // public function storeCategory()
     // {
     //     return $this->belongsTo('App\StoreCategory', 'store_category_id');
     // }

     // public function country()
     // {
     //     return $this->belongsTo('App\Country', 'country_id');
     // }

     // public function billingCountry()
     // {
     //     return $this->belongsTo('App\Country', 'billing_country_id');
     // }

     // public function deliveryCountry()
     // {
     //     return $this->belongsTo('App\Country', 'delivery_country_id');
     // }

     // public function hasOrdered()
     // {
     //    return $this->hasMany('App\Order', 'customer_id');
     // }

     // public function payments()
     // {
     //    return $this->hasMany('App\CustomerPaymentMethod', 'customer_id');
     // }

     public function chreck_cell($pid, $sid)
     {
        return StoreProduct::where('product_id', $pid)->where('store_id', $sid)->get();
     }
}