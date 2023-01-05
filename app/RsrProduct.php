<?php namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class RsrProduct extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'rsr_products';
    // protected $fillable = ['rsr_stock_number', 'upc_code', 'product_description', 'department_number', 'manufacturer_id', 'retail_price', 'rsr_pricing', 'product_weight', 'inventory_quantity', 'model', 'full_manufacturer_name', 'manufacturer_part_number', 'allocated_closeout_deleted', 'expanded_product_description', 'discount_percentage', 'dicounted_price', 'retail_price', 'retailer_price', 'image_name', 'retailer_price', 'quantity', 'material_type', 'warranty', 'web_site', 'video', 'video_type', 'video_code', 'audio', 'color', 'color_id', 'measurement_id', 'weight', 'length', 'width', 'height','order_no','offer_started_at', 'offer_ended_at', 'available_at','is_featured','is_purchase_enabled','is_allowed_review','status', 'model_id', 'sale_price', 'is_price_display', 'is_retail_price_display', 'is_sale_price_display'];

    protected $guarded = ['photos'];

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

    // 
    public function is_wholesale_customer()
    {
        if (auth()->user()) {
            return auth()->user()->hasRole('wholesale_customer');
        }
    }

    // RSR-----------
    public function rsr_category()
    {
        return $this->belongsTo('App\RsrMainCategory', 'department_number', 'department_id');
    }

    // HR image Path
    public function get_hr_image_by_manufacturer()
    {
        $fileName = pathinfo($this->image_name, PATHINFO_FILENAME);
        $extension = pathinfo($this->image_name, PATHINFO_EXTENSION);
        $firstLetter = strtolower(substr($this->manufacturer_id,0,1));
        $manufacturerFirstLetter = is_numeric($firstLetter) ? "#" : $firstLetter;
        $fullManufacturerName = str_slug($this->full_manufacturer_name);
        $imageName = $fileName."_HR.".$extension;

        return 'storage/products/ftp_highres_images/manufacturers/'.$manufacturerFirstLetter .'/'.$fullManufacturerName.'/'.$imageName;
    }

    public function is_in_stock()
    {
        if ($this->inventory_quantity > 0) {
            return true;
        }
        return false;
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

    public function rsr_attribute()
    {
        return $this->belongsTo('App\RsrProducAttribute', 'rsr_stock_number', 'rsr_stock_number');
    }

    // public function get_rsr_retail_price()
    // {
    //     $retailPricePercentage = Option::first()->retail_price_percentage;

    //     $mainCategory = $this->rsr_category ? $this->rsr_category : NULL;
        
    //     if ($mainCategory && $mainCategory->retail_price_percentage) {
    //         return $this->rsr_pricing + $this->rsr_pricing * $mainCategory->retail_price_percentage / 100;
    //     }else{
    //         return $this->rsr_pricing + $this->rsr_pricing * $retailPricePercentage / 100;
    //     }
    // }

    public function get_rsr_retail_price()
    {
        $retailPricePercentage = Option::first()->retail_price_percentage;
        
        $mainCategory = $this->rsr_category ? $this->rsr_category : NULL;
        
        if ($mainCategory && $mainCategory->retail_price_percentage) {
            $categoryWisePrice = $this->rsr_pricing + $this->rsr_pricing * $mainCategory->retail_price_percentage / 100;
            if ($this->retail_map > $categoryWisePrice) {
                return $this->retail_map;
            }else{
                return $categoryWisePrice;
            }
        }else{
            $defaultRetailPrice =  $this->rsr_pricing + $this->rsr_pricing * $retailPricePercentage / 100;
            
            if ($this->retail_map > $defaultRetailPrice) {
                return $this->retail_map;
            }else{
                return $defaultRetailPrice;
            }
        }
    }

    public function haveRsrPhotos()
    {
       return $this->hasMany('App\RsrProductPhoto', 'product_id', 'rsr_stock_number');
    }

    // High resolution images
    public function get_hr_image_by_category()
    {
        $fileName = pathinfo($this->image_name, PATHINFO_FILENAME);
        $extension = pathinfo($this->image_name, PATHINFO_EXTENSION);
        $imageName = $fileName."_HR.".$extension;
        $categoryName =  str_slug($this->rsr_category->category_name);
        
        return 'storage/products/ftp_highres_images/categories/'.$categoryName .'/'.$imageName;
    }

    public function get_hr_image_storage_path_by_category()
    {
        $fileName = pathinfo($this->image_name, PATHINFO_FILENAME);
        $extension = pathinfo($this->image_name, PATHINFO_EXTENSION);
        $imageName = $fileName."_HR.".$extension;
        $categoryName =  str_slug($this->rsr_category->category_name);
        
        return 'products/ftp_highres_images/categories/'.$categoryName .'/'.$imageName;
    }

    public function src_rsr_hr_image()
    {
        if ($this->image_name) {
            if (\Storage::exists($this->get_hr_image_storage_path_by_category())) {
                return $this->get_hr_image_by_category();
            }else{
                return 'site/defaults/image-coming-soon.png';
            }
        }else{
            return 'site/defaults/image-not-found.png';
        }
    }

    // low resolution images
    public function get_lr_image_by_category()
    {
        $imageName = $this->image_name;
        $categoryName =  str_slug($this->rsr_category->category_name);
        
        return 'storage/products/ftp_images/categories/'.$categoryName .'/'.$imageName;
    }

    public function get_lr_image_storage_path_by_category()
    {
        $imageName = $this->image_name;
        $categoryName =  str_slug($this->rsr_category->category_name);
        
        return 'products/ftp_images/categories/'.$categoryName .'/'.$imageName;
    }

    public function src_rsr_lr_image()
    {
        if ($this->image_name) {
            if (\Storage::exists($this->get_lr_image_storage_path_by_category())) {
                return $this->get_lr_image_by_category();
            }else{
                return 'site/defaults/image-coming-soon.png';
            }
        }else{
            return 'site/defaults/image-not-found.png';
        }
    }

    // Gallery
    public function rsr_gallery_hr_image($number)
    {
        $fileName = pathinfo($this->image_name, PATHINFO_FILENAME);
        $extension = pathinfo($this->image_name, PATHINFO_EXTENSION);
        $imageName = substr($fileName, 0, -2)."_".$number."_HR.".$extension;
        return $imageName;
    }

    public function rsr_gallery_lr_image($number)
    {
        $fileName = pathinfo($this->image_name, PATHINFO_FILENAME);
        $extension = pathinfo($this->image_name, PATHINFO_EXTENSION);
        $imageName = substr($fileName, 0, -2)."_".$number.".".$extension;
        return $imageName;
    }

    public function rsr_gallery_hr_image_count()
    {
        $fileName = pathinfo($this->image_name, PATHINFO_FILENAME);
        $extension = pathinfo($this->image_name, PATHINFO_EXTENSION);
        $imageName = substr($fileName, 0, -2) . "_*." . $extension;
        $categoryName =  str_slug($this->rsr_category->category_name);
        $totalImages =  count(glob(public_path('storage/products/ftp_highres_images/categories/'. $categoryName . '/' . substr($fileName, 0, -2) . '_*_HR' . '*')));

        return $totalImages > 0 ? true : false;
    }

    public function rsr_gallery_hr_images()
    {
        $fileName = pathinfo($this->image_name, PATHINFO_FILENAME);
        $extension = pathinfo($this->image_name, PATHINFO_EXTENSION);
        $imageName = substr($fileName, 0, -2) . "_*." . $extension;
        $categoryName =  str_slug($this->rsr_category->category_name);

        return glob(public_path('storage/products/ftp_highres_images/categories/'. $categoryName . '/' . substr($fileName, 0, -2) . '_*_HR' . '*'));
    }

    public function image_from_path($path)
    {
        $pathToArray = explode('/', $path);
        return end($pathToArray);
    }

    // low res gallery
    public function rsr_gallery_lr_image_count()
    {
        $fileName = pathinfo($this->image_name, PATHINFO_FILENAME);
        $extension = pathinfo($this->image_name, PATHINFO_EXTENSION);
        $imageName = substr($fileName, 0, -2) . "_*." . $extension;
        $categoryName =  str_slug($this->rsr_category->category_name);
        $totalImages =  count(glob(public_path('storage/products/ftp_images/categories/'. $categoryName . '/' . substr($fileName, 0, -2) . '_*' . '*')));

        return $totalImages > 0 ? true : false;
    }

    public function rsr_gallery_lr_images()
    {
        $fileName = pathinfo($this->image_name, PATHINFO_FILENAME);
        $extension = pathinfo($this->image_name, PATHINFO_EXTENSION);
        $imageName = substr($fileName, 0, -2) . "_*." . $extension;
        $categoryName =  str_slug($this->rsr_category->category_name);

        return glob(public_path('storage/products/ftp_images/categories/'. $categoryName . '/' . substr($fileName, 0, -2) . '_*' . '*'));
    }
    // 

    public function rsr_sell_description()
    {
        return $this->belongsTo('App\RsrSellDescription', 'rsr_stock_number', 'rsr_stock_number')->where('sell_copy_feature', 'SELLCOPY');
    }

    public function rsr_sell_feature()
    {
        return $this->belongsTo('App\RsrSellDescription', 'rsr_stock_number', 'rsr_stock_number')->where('sell_copy_feature', 'FEATURES');
    }

    public function rsr_message()
    {
        return $this->belongsTo('App\RsrProductMessage', 'rsr_stock_number', 'rsr_stock_number');
    }

    public function rsr_related_products()
    {
       return $this->hasMany('App\RsrProductXref', 'rsr_stock_number', 'rsr_stock_number');
    }

    public function rsr_related_product_categories()
    {
       return $this->hasMany('App\RsrProductXref', 'rsr_stock_number', 'rsr_stock_number')->groupBy('associated_department_number')->orderBy('associated_rsr_stock_number');
    }

    public function related_products_by_main_category($rsrStockNumber, $categoryId)
    {
        return RsrProductXref::where('rsr_stock_number', $rsrStockNumber)->where('associated_department_number', $categoryId)->get();
    }
}
