<?php namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImport extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'products_import';
    protected $fillable = ['sku', 'upc', 'supplier_id',  'category_id', 'user_id', 'name', 'description', 'content', 'price', 'special_price', 'quantity', 'year', 'brand_id', 'model_id', 'material_type', 'warranty', 'main_image', 'weight', 'engine_type', 'color', 'interior_color', 'exterior_color', 'fuel_type', 'video_type', 'video_code', 'status', 'offer_started_at', 'offer_ended_at', 'date_available', 'display','part_number','brand_label', 'product_description_extended', 'price_type_retail','primary_image_file_name','brand_label'];

    public function user() 
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo('App\ProductCategorySub', 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\ProductBrand', 'brand_id');
    }

    public function model()
    {
        return $this->belongsTo('App\ProductModel', 'model_id');
    }
}
