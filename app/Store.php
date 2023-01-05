<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'stores';
    protected $fillable = ['title', 'division', 'store_category_id', 'banner', 'legacy', 'store_id', 'address_1', 'address_2', 'city', 'state', 'zip', 'phone_no', 'mobile_no', 'slug', 'description', 'image', 'status'];

     public function user()
     {
         return $this->belongsTo('App\User', 'user_id');
     }

     public function store_products()
     {
        return $this->hasMany('App\StoreProduct', 'store_id', 'store_id');
     }

     public function stores()
     {
        return $this->hasMany('App\Store', 'division', 'store_id');
     }

     public function getStoresByDivision($division)
     {
         return Store::where('division', $division)->where(status, 1)->get();
     }

     public function getTableColumns()
     {
         // return $this->getConnection()->select(
         //     (new \Illuminate\Database\Schema\Grammars\MySqlGrammar)->compileColumnListing()
         //         .' order by ordinal_position',
         //     [$this->getConnection()->getDatabaseName(), $this->getTable()]
         // );

         $results = $this->getConnection()->select(
             (new \Illuminate\Database\Schema\Grammars\MySqlGrammar)->compileColumnListing()
                 .' order by ordinal_position',
             [$this->getConnection()->getDatabaseName(), $this->getTable()]
         );
         return $this->getConnection()->getPostProcessor()->processColumnListing($results);
     }

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

     public function storeCategory()
     {
         return $this->belongsTo('App\StoreCategory', 'store_category_id');
     }
}