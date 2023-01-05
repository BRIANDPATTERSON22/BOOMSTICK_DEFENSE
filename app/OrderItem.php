<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $table = 'orders_items';
    protected $fillable = ['quantity','price','color_id','status','old_quantity','size_id', 'product_name'];

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function color()
    {
        return $this->belongsTo('App\Color', 'color_id');
    }

    public function hasStore()
    {
        return $this->belongsTo('App\Store', 'store_id', 'store_id');
    }

    // public function hasStoreManager()
    // {
    //     return $this->belongsTo('App\StoreManagerHasStore', 'store_id', 'store_id');
    // }

    public function haveSalesPersons()
    {
        // $salesPersonIds = $this->salesPersonHasStore->whereIn('store_id', $storeIds)->pluck('sales_person_id');
        // $salesPersonEmails = $this->salesPerson->whereIn('id', $salesPersonIds)->pluck('email');        
        return $this->hasMany('App\SalesPersonHasStore', 'store_id', 'store_id');
    }
}
