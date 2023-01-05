<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductHasRelatedProduct extends Model
{
    protected $table = 'product_has_related_products';
    protected $fillable = ['product_id', 'related_product_id',];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
