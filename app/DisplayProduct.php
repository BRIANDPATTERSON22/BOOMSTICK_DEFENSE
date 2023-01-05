<?php namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class DisplayProduct extends Model
{
    // use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'display_products';
    protected $fillable = ['type', 'product_id', 'store_type'];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function haveProducts()
    {
        return $this->hasMany('App\Product', 'product_id');
    }

    public function rsrProduct()
    {
        return $this->belongsTo('App\RsrProduct', 'product_id', 'rsr_stock_number');
    }

    public function get_store_type()
    {
        if ($this->store_type == 0) {
            return "Boomstick";
        }elseif($this->store_type == 1){
            return "RSR Group";
        }
    }
}