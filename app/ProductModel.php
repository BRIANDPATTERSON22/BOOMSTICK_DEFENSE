<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'products_model';
    protected $fillable = ['name', 'slug', 'image', 'status'];

    public function product()
    {
        return $this->hasMany('App\Product', 'model_id');
    }
}
