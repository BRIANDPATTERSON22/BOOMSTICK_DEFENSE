<?php namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductColor extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'products_color';
    protected $fillable = ['product_id', 'color_id','status'];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function color()
    {
        return $this->belongsTo('App\Color', 'color_id');
    }
}
