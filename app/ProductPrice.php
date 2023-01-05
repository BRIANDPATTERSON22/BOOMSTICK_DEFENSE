<?php namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'products_price';
    protected $fillable = ['product_id', 'size_id','status','price','sku'];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function size()
    {
        return $this->belongsTo('App\Size', 'size_id');
    }
}
