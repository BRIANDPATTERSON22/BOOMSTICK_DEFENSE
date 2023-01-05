<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductNotification extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $table = 'product_notifications';
    protected $fillable = ['title', 'product_id', 'rsr_product_id', 'email', 'status'];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function rsr_product()
    {
        return $this->belongsTo('App\RsrProduct', 'product_id', 'rsr_stock_number');
    }
}
