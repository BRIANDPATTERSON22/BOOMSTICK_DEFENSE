<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomerPaymentMethod extends Authenticatable
{
    protected $table = 'customer_payment_methods';
    protected $fillable = ['customer_id', 'payment_id'];

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}