<?php namespace App;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Product extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'products';
    
    protected $fillable = ['product_id', 'title', 'upc', 'sku', 'slug', 'user_id', 'main_category_id', 'sub_category_id', 'sub_category_type_id', 'brand_id', 'model_id', 'color_id', 'quantity', 'quantity_step_by', 'price', 'discount_percentage', 'dicounted_price', 'vat', 'tax', 'offer_started_at', 'offer_ended_at', 'available_at', 'short_description', 'content', 'image', 'main_image', 'banner_image', 'video', 'youtube', 'vimeo', 'audio', 'soundcloud', 'warranty', 'external_link', 'material_type','size','weight', 'length', 'width','height','is_featured','is_purchase_enabled','is_review_enabled', 'is_retail_price_enabled', 'is_firearm', 'is_disclaimer_agreement_enabled', 'is_warning_enabled', 'retail_price', 'ak','al' ,'ar', 'az', 'ca', 'co', 'ct', 'dc', 'de', 'fl', 'ga', 'hi', 'ia', 'id_idaho', 'il', 'in', 'ks', 'ky', 'la', 'ma', 'md', 'me', 'mi', 'mn', 'mo', 'ms', 'mt', 'nc', 'nd', 'ne', 'nh', 'nj', 'nm', 'nv', 'ny', 'oh', 'ok', 'or', 'ph', 'ri', 'sc', 'sd', 'tn', 'tx', 'ut', 'va', 'vt', 'wa', 'wi', 'wv', 'wy', 'manufacturer_id', 'full_manufacturer_name', 'manufacturer_part_number', 'caliber', 'barrel_length', 'action', 'finish', 'grips', 'hand', 'type', 'wt_characteristics'];

    // protected $guarded = ['category_main_id', 'category_id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function rel_main_category()
    {
        return $this->belongsTo('App\ProductCategory', 'main_category_id');
    }

    public function category()
    {
        return $this->belongsTo('App\ProductCategorySub', 'category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo('App\ProductCategorySub', 'sub_category_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\ProductBrand', 'brand_id');
    }

    public function model()
    {
        return $this->belongsTo('App\ProductModel', 'model_id');
    }

    public function views()
    {
        return $this->hasMany('App\ProductView', 'product_id');
    }

    public function sales()
    {
        return $this->hasMany('App\OrderItem', 'product_id');
    }

    public function productColor()
    {
        return $this->hasMany('App\ProductColor', 'product_id');
    }
    
    public function firstColor() 
    {
        return $this->hasOne('App\ProductColor', 'product_id')->oldest();
    }

    public function hasProduct($pid, $cid)
    {
        return WishList::where('product_id', $pid)->where('customer_id', $cid)->first();
    }

    public function productSize()
    {
        return $this->hasMany('App\ProductSize', 'product_id');
    }

    public function colorData()
    {
        return $this->belongsTo('App\Color', 'color_id');
    }

    public function sizeData()
    {
        return $this->belongsTo('App\Size', 'measurement_id');
    }

    public function children()
    {
        return $this->hasMany('App\Product', 'parent_product_id');
    }

    public function parent() {
        return $this->belongsTo('App\Product', 'parent_product_id'); 
    }

    public function hasColor($pid, $colorId, $measurement)
    {
        return Product::where('id', $pid)->where('color_id', $colorId)->where('measurement', $measurement)->first();
    }

    public function getTableColumns()
    {
        $results = $this->getConnection()->select(
            (new \Illuminate\Database\Schema\Grammars\MySqlGrammar)->compileColumnListing()
                .' order by ordinal_position',
            [$this->getConnection()->getDatabaseName(), $this->getTable()]
        );
        return $this->getConnection()->getPostProcessor()->processColumnListing($results);
    }

    public function store_products_data()
    {
       return $this->hasMany('App\StoreProduct', 'product_id');
    }

    public function store_products_data_arr($pid)
    {
        $availableStoresIdArr = StoreProduct::whereStatus('1')->where('product_id', $pid)->pluck('store_id')->toArray();

        return Store::select('store_id', \DB::raw('CONCAT(banner, "-", store_id, " - ", address_1) AS display_name'))
           ->whereIn('store_id', $availableStoresIdArr)
           ->pluck('display_name', 'store_id');
    }

    public function check_cell($pid, $sid)
    {
       return StoreProduct::where('product_id', $pid)->where('store_id', $sid)->first();
    }

    public function firstStore() 
    {
        // return $this->hasOne('App\Store', 'product_id')->oldest();
        return $this->hasOne('App\StoreProduct', 'product_id')->oldest();
    }

    public function havePhotos()
    {
       return $this->hasMany('App\ProductPhoto', 'product_id');
    }

    // 
    public function is_wholesale_customer()
    {
        if (auth()->user()) {
            return auth()->user()->hasRole('wholesale_customer');
        }
    }

    public function cartQuantity()
    {
        // dump($this->id);
        // return Cart::instance('cart')->content()->where('id', $productId)->first() ?  Cart::instance('cart')->content()->where('id', $productId)->first()->qty : null;
        return Cart::instance('cart')->content()->where('id', $this->id)->first() ? Cart::instance('cart')->content()->where('id', $this->id)->first()->qty : 0;
    }

    public function availableQuantity()
    {
        return $this->quantity - $this->cartQuantity();
    }

    public function is_in_stock()
    {
        if ($this->quantity > 0 && $this->is_purchase_enabled == 1) {
            return true;
        }
        return false;
    }

    public function you_tube_video_id()
    {
        $youTubeUrl = explode('/', $this->youtube);
        $lastSegments = end($youTubeUrl);
        return $lastSegments;
    }

    public function you_tube_url()
    {
        $youTubeUrl = explode('/', $this->youtube);
        $lastSegments = end($youTubeUrl);
        return "https://www.youtube.com/watch?v={$lastSegments }";
    }

    public function you_tube_thumbnail()
    {
        $youTubeUrl = explode('/', $this->youtube);
        $lastSegments = end($youTubeUrl);
        return "http://img.youtube.com/vi/{$lastSegments}/hqdefault.jpg";
    }

    public function has_model()
    {
        return $this->belongsTo('App\ProductModel', 'model_id');
    }
}
