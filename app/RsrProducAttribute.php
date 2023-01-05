<?php namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class RsrProducAttribute extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'rsr_product_attributes';
    // protected $fillable = ['rsr_stock_number', 'upc_code', 'product_description', 'department_number', 'manufacturer_id', 'retail_price', 'rsr_pricing', 'product_weight', 'inventory_quantity', 'model', 'full_manufacturer_name', 'manufacturer_part_number', 'allocated_closeout_deleted', 'expanded_product_description', 'discount_percentage', 'dicounted_price', 'retail_price', 'retailer_price', 'image_name', 'retailer_price', 'quantity', 'material_type', 'warranty', 'web_site', 'video', 'video_type', 'video_code', 'audio', 'color', 'color_id', 'measurement_id', 'weight', 'length', 'width', 'height','order_no','offer_started_at', 'offer_ended_at', 'available_at','is_featured','is_purchase_enabled','is_allowed_review','status', 'model_id', 'sale_price', 'is_price_display', 'is_retail_price_display', 'is_sale_price_display'];

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\RsrProduct', 'rsr_stock_number', 'rsr_stock_number');
    }
}
