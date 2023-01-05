<?php namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class RsrProductXref extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'rsr_product_xref';
    // protected $fillable = ['rsr_stock_number', 'upc_code', 'product_description', 'department_number', 'manufacturer_id'';

    protected $guarded = [];

    public function main_category()
    {
        return $this->belongsTo('App\RsrMainCategory', 'associated_department_number', 'department_id');
    }

    public function rsr_related_product()
    {
        return $this->belongsTo('App\RsrProduct', 'associated_rsr_stock_number', 'rsr_stock_number');
    }
}