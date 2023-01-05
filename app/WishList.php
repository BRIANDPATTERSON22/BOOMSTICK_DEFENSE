<?php namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class WishList extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'wishlist';
    protected $fillable = ['customer_id', 'product_id'];

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
