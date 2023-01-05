<?php namespace App\Http\Controllers\Admin;

use App\Color;
use App\DisplayProduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductColorRequest;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Requests\Admin\ProductSizeRequest;
use App\Http\Requests\Admin\RsrProductRequest;
use App\OrderItem;
use App\Product;
use App\ProductBrand;
use App\ProductCategory;
use App\ProductCategorySub;
use App\ProductCategoryType;
use App\ProductColor;
use App\ProductHasRelatedProduct;
use App\ProductModel;
use App\ProductPhoto;
use App\ProductSize;
use App\RsrMainCategory;
use App\RsrProduct;
use App\RsrProductPhoto;
use App\RsrSubCategory;
use App\Size;
use App\Store;
use App\StoreCategory;
use App\StoreProduct;
use Auth;
use DateTime;
use Excel;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Session;
use Zipper;

class RsrProductController extends Controller
{
    public function __construct(Product $product, ProductCategory $category, ProductCategorySub $categorySub, ProductPhoto $photo, ProductBrand $brand, ProductModel $model, ProductColor $productColor, Color $color, ProductCategoryType $productCategoryType, Size $size, ProductSize $productSize, Store $store, StoreProduct $storeProduct, StoreCategory $storeCategory, ProductHasRelatedProduct $productHasRelatedProduct,  RsrProduct $rsrProduct, RsrMainCategory $rsrMainCategory, RsrSubCategory $rsrSubCategory, RsrProductPhoto $rsrProductPhoto)
    {
        $this->module = "rsr-product";
        $this->data = $product;
        $this->category = $category;
        $this->categorySub = $categorySub;
        $this->brand = $brand;
        $this->model = $model;
        $this->photo = $photo;
        $this->productColor = $productColor;
        $this->color = $color;
        $this->productCategoryType = $productCategoryType;
        $this->size = $size;
        $this->productSize = $productSize;
        $this->store = $store;
        $this->storeProduct = $storeProduct;
        $this->storeCategory = $storeCategory;
        $this->productHasRelatedProduct = $productHasRelatedProduct;

        $this->rsrProduct = $rsrProduct;
        $this->rsrProductPhoto = $rsrProductPhoto;
        $this->rsrMainCategory = $rsrMainCategory;
        $this->rsrSubCategory = $rsrSubCategory;

        $this->option = Cache::get('optionCache');
        $this->middleware('auth');
    }

    public function get_index()
    {
        $module = $this->module;
        $deleteCount = $this->data->onlyTrashed()->count();

        // $allData = $this->rsrProduct->orderBy('id', 'DESC')->paginate(20);
        // $categories =  $this->rsrMainCategory->orderBY('department_name', 'ASC')->get();
        // $subCategories = $this->rsrSubCategory->get();
        // $brand = $this->rsrProduct->groupBy('manufacturer_id')->paginate(24);

        if (count(request()->all()) > 0) {
            $allDataBuilder = RsrProduct::query();

            request()->search ? 
                $allDataBuilder
                ->orWhere('rsr_stock_number', 'like', '%' .request()->search. '%')
                ->orWhere('upc_code', 'like', '%' .request()->search. '%')
                ->orWhere('product_description', 'like', '%' .request()->search. '%')
                ->orWhere('full_manufacturer_name', 'like', '%' .request()->search. '%')
                ->orWhere('model', 'like', '%' .request()->search. '%')
                ->orWhere('manufacturer_part_number', 'like', '%' .request()->search. '%')
                ->orWhere('expanded_product_description', 'like', '%' .request()->search. '%')
                ->get() 
                : null;

            $allData = $allDataBuilder->orderBy('product_description', 'ASC')->paginate(24)->appends([
                'search' => request()->search,
            ]);

        }else{
            $allData = $this->rsrProduct->orderBy('product_description', 'ACS')->paginate(24);
        }

        return view('admin.'.$module.'.index', compact('module', 'deleteCount', 'allData'));
    }

    public function get_archive($year)
    {
        $module = $this->module;

        $allData = $this->data->where('status', 1)
            // ->where('created_at', 'like', $year.'%')
            ->orderBy('id', 'DESC')
            ->paginate(20);
            
        $categories = $this->category->where('status', 1)->pluck('name', 'id');
        $categorySubs = $this->categorySub->where('status', 1)->pluck('name', 'id');
        $categoryTypes = $this->productCategoryType->where('status', 1)->pluck('name', 'id');
        $brand = $this->brand->where('status', 1)->pluck('name', 'id');

        return view('admin.'.$module.'.index', compact('allData', 'module', 'year', 'categories', 'categorySubs', 'categoryTypes', 'brand'));
    }

    public function get_trash()
    {   
        $categories = $this->category->where('status', 1)->pluck('name', 'id');
        $categorySubs = $this->categorySub->where('status', 1)->pluck('name', 'id');
        $categoryTypes = $this->productCategoryType->where('status', 1)->pluck('name', 'id');
        $brand = $this->brand->where('status', 1)->pluck('name', 'id');

        $module = $this->module;
        // $allData = $this->data->onlyTrashed()->get();
        $allData = $this->data->onlyTrashed()->paginate(20);

        return view('admin.'.$module.'.index', compact('allData', 'module', 'categories', 'categories', 'categoryTypes', 'categorySubs' ,'brand'));
    }

    public function get_add()
    {
        $module = $this->module;

        $singleData = $this->data;
        $photos = null;
        $categories = $this->category->where('status', 1)->pluck('name', 'id');
        $categorySubs = $this->categorySub->where('status', 1)->pluck('name', 'id');
        // $categoryTypes = $this->productCategoryType->where('status', 1)->pluck('name', 'id');
        $brand = $this->brand->where('status', 1)->pluck('name', 'id');
        $model = $this->model->where('status', 1)->pluck('name', 'id');
        // $sizes = $this->size->where('status', 1)->pluck('name', 'id');
        // $sizesDescription = $this->size->where('status', 1)->pluck('name', 'id');
        // $sizesMeasurement = $this->size->where('status', 1)->pluck('measurement_type', 'id');
        $colors = $this->color->where('status', 1)->pluck('name', 'id');
        // $parentProducts = $this->data->where('status', 1)->pluck('name', 'id');

        // $sizeWithSymbol = $this->size->select('id', DB::raw("concat(name, ' - ',measurement_type) as id_name"))
        //                 ->orderBy('name')
        //                 ->pluck('id_name', 'id');

        // $pluckStorsData = $this->store->select('store_id', 'division', DB::raw("concat(banner, ' - ',store_id) as store_info"))
        //                 ->orderBy('division')
        //                 ->pluck('store_info', 'store_id');

        // $pluckStorsData = $this->store->where('status', 1)->pluck('banner', 'store_id');

        // $pluckStorsData = $this->store->where('status', 1)->select('city', 'store_id')->->toSql();

        // $pluckStorsData = $this->store->where('status', 1)->select('division', 'city', 'store_id')->groupBy('division')->orderBy('division', 'ASC')->get()->dd(); 

        // $pluckStorsData = $this->store->where('status', 1)->groupBy('division')->pluck('division')->toArray();

        $storeCategoriesData = $this->storeCategory->where('status', 1)->select('id', 'title')->with('storesData')->get();

        $relatedProducts = $this->data->where('status', 1)->select('id', 'title')->get();

        // \DB::listen(function($sql) {
        //     var_dump($sql);
        // });

        // return view('admin.'.$module.'.add_edit', compact('singleData', 'categories', 'categorySubs', 'photos', 'module','brand','model','categoryTypes','sizesDescription', 'sizesMeasurement', 'colors', 'sizeWithSymbol', 'pluckStorsData', 'storeCategoriesData'));

        return view('admin.'.$module.'.add_edit', compact('singleData', 'categories', 'categorySubs', 'photos', 'module', 'brand', 'colors', 'storeCategoriesData', 'model', 'relatedProducts'));
    }

    public function post_add(ProductRequest $request)
    {
        $module = $this->module;
        $filename2 =null;
        $files = Input::file('photo.image');

        //Main_Image save function
        if($request->main_image) {
            $file = $request->main_image;
            Image::make($file)->widen(400, function ($constraint) {$constraint->upsize(); })->crop(400,400)->fill('#ffffff', 0, 0)->save($file);
            $filename2= time().'.'.$file->getClientOriginalExtension();
            $filepath = $module.'s/images/'.$filename2;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $bannerImage =null;
        //Main_Image save function
        if($request->banner_image) {
            $fileBannerImage = $request->banner_image;
            // Image::make($fileBannerImage)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($fileBannerImage);
            Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->crop(1024,350)->fill('#ffffff', 0, 0)->save($file);

            $bannerImage= time().'.'.$fileBannerImage->getClientOriginalExtension();
            $filepath = $module.'s/banner-images/'.$bannerImage;
            Storage::put($filepath, file_get_contents($fileBannerImage), 'public');
        }

        $this->data->fill($request->all());
        $this->data->main_category_id = $request->category_main_id;
        $this->data->main_image = $filename2;
        // $this->data->main_image = $request->main_image ? $filename2 : "image-coming-soon.jpg";
        $this->data->banner_image = $bannerImage;
        $this->data->user_id = Auth::id();
        $this->data->status = 1;
        // $request->is_price_display == 1 ? $this->data->is_price_display = 1 : $this->data->is_price_display = 0;
        // $request->is_retail_price_display == 1 ? $this->data->is_retail_price_display = 1 : $this->data->is_retail_price_display = 0;
        // $request->is_sale_price_display == 1 ? $this->data->is_sale_price_display = 1 : $this->data->is_sale_price_display = 0;
        $this->data->is_retail_price_display = 1;
        $this->data->is_sale_price_display = 1;
        $this->data->is_purchase_enabled = 1;

        $slug = str_slug($request->title);
        $existingSlugs = $this->data->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->data->slug =$slug.$existingSlugs : $this->data->slug = $slug;

        //External sources
        if($request->source) {
            $url = $request->source;
            if(stripos($url, "youtube") !== false) {
                parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
                $this->data->video_type = "youtube";
                $this->data->video_code = $my_array_of_vars['v'];
            }elseif(stripos($url, "vimeo") !== false) {
                $this->data->video_type = "vimeo";
                $segments = explode('/',$url);
                $this->data->video_code = end($segments);
            }elseif(stripos($url, "facebook") !== false) {
                $this->data->video_type = "facebook";
                $this->data->video_code = $request->source;
            }else{
                return redirect()->back()->with('error', 'Not a supported source URL format')->withInput();
            }
        }

        // Prices
        // $this->data->dicounted_price = $request->price - ( ($request->discount_percentage / 100) * $request->price);
        // $this->data->dicounted_price = $request->retail_price - ( ($request->discount_percentage / 100) * $request->retail_price);
        $this->data->dicounted_price = $request->sale_price - ( ($request->discount_percentage / 100) * $request->sale_price);


        // // Grouping size-symbol
        // if ($request->measurement_id) {
        //     // $measurementSymbol = $this->size->where('id', $request->measurement_id)->first()->measurement_type;
        //     $measurementSymbol = $this->data->sizeData->measurement_type;
        // }
        // // $this->data->size_and_symbol = $request->measurement && $request->measurement_id ? number_format($request->measurement,2).'-'.$measurementSymbol : null;
        // $this->data->size_and_symbol = $request->measurement && $request->measurement_id ? $request->measurement.'-'.$measurementSymbol : null;
        // $this->user_id = Auth::id();
        $this->data->save();
        $dataId = $this->data->id;

        //Gallery upload
        // if(count($files)>0) {
        if($files) {
            $images = null;
            $i = 0;
            foreach ($files as $file) {
                $i++;
                // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
                Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->crop(1024,1024)->fill('#ffffff', 0, 0)->save($file);
                $filename = $i . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filepath = $module . 's/photos/'.$dataId.'/'.$filename;
                $upload_success = Storage::put($filepath, fopen($file, 'r+'), 'public');
                if ($upload_success) {
                    $images[] = [
                        'order' => $i,
                        'image' => $filename,
                        'product_id' => $dataId,
                        'created_at' => new DateTime,
                        'updated_at' => new DateTime,
                    ];
                }
            }
            $this->photo->insert($images);
        }

        // Add images
        // $addImages = Input::file('photo.image');
        // if($addImages) {
        //     $images = null;
        //     $i = 0;
        //     foreach ($addImages as $addImg) {
        //         $i++;
        //         // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
        //         Image::make($addImg)->widen(370, function ($constraint) {$constraint->upsize(); })->crop(370,222)->fill('#f0f0f0', 0, 0)->save($addImg);
        //         $addImageName = $i . '_' . time() . '.' . $addImg->getClientOriginalExtension();
        //         $filepath = $module . 's/photos/'.$dataId.'/'.$addImageName;
        //         $upload_success = Storage::put($filepath, fopen($addImg, 'r+'), 'public');
        //         if ($upload_success) {
        //             $arrImages[] = [
        //                 'order' => '1_'.$i,
        //                 'image' => $addImageName,
        //                 'type' => 1,
        //                 'product_id' => $dataId,
        //                 'created_at' => new DateTime,
        //                 'updated_at' => new DateTime,
        //             ];
        //         }
        //     }
        //     $this->photo->insert($arrImages);
        // }



        //Assign Product to
        $availableStores = null;
        if($request->stores) {
            foreach ($request->stores as $addStore) {
                $availableStores[] = [
                    'product_id' => $dataId,
                    'store_id' => $addStore,
                    // 'store_category_id' => $this->store->where('store_id', $addStore)->first()->store_category_id,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ];
            }
        }

        if($availableStores) {
            $this->storeProduct->insert($availableStores);
        }

        //Assign Related Products
        $availableRelatedProducts = null;
        if($request->related_products) {
            foreach ($request->related_products as $addRelatedProduct) {
                $availableRelatedProducts[] = [
                    'product_id' => $dataId,
                    'related_product_id' => $addRelatedProduct,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ];
            }
        }

        if($availableRelatedProducts) {
            $this->productHasRelatedProduct->insert($availableRelatedProducts);
        }

        return redirect('admin/'.$module.'/'.$dataId.'/view')->with('success', 'Data '.$this->data->name.' has been created');
    }


    public function get_edit($id)
    {
        $module = $this->module;

        $singleData = $this->rsrProduct->find($id);
        $rsrMainCategories = $this->rsrMainCategory->pluck('department_name', 'department_id');
        $photos = $this->rsrProductPhoto->where('product_id', $singleData->rsr_stock_number)->get();

        return view('admin.'.$module.'.add_edit',compact('singleData', 'module', 'rsrMainCategories', 'photos'));
    }

    public function post_edit(RsrProductRequest $request, $id)
    {
        $module = $this->module;

        // dd($request->all());

        $this->rsrProduct = $this->rsrProduct->find($id);
        $this->rsrProduct->fill($request->all());
        $request->status == 1 ? $this->rsrProduct->status = 1 : $this->rsrProduct->status = 0;
        $this->rsrProduct->save();
        
        $productId = $this->rsrProduct->rsr_stock_number;

        //--Product Gallery--
        $files = $request->photos;
        $photos = $this->rsrProductPhoto->where('product_id', $productId)->orderBy('order', 'DESC')->get();

        if($files){
            $images = null;
            count($photos) > 0 ? $i = $photos[0]->order : $i = 1;
            foreach ($files as $file) {
                $i++;
                // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
                Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->crop(1024,1024)->fill('#ffffff', 0, 0)->save($file);

                $filename = $i.'_'.time().'.'.$file->getClientOriginalExtension();
                $filepath = $module.'s/rsr-photos/'.$productId.'/'.$filename;
                $upload_success = Storage::put($filepath, fopen($file, 'r+'), 'public');
                if($upload_success) {
                    $images[] = [
                        'order' => $i,
                        'image' => $filename,
                        'product_id' => $productId,
                        'status' => 1,
                        'created_at' => new DateTime,
                        'updated_at' => new DateTime,
                    ];
                }
            }
            if($images) {
                $this->rsrProductPhoto->insert($images);
            }
        }

        return redirect()->back()->with('success', 'Data '.$this->data->name.' has been updated');
    }

    public function get_view($id)
    {
        $module = $this->module;
        $moduleStore = 'store';

        $singleData = $this->rsrProduct->find($id);
        $photos = $this->photo->where('product_id', $id)->get();
        $allData = $this->productColor->where('product_id', $id)->get();
        $productSize = $this->productSize->where('product_id', $id)->get();
        $colors = $this->color->where('status', 1)->pluck('name', 'id');
        $sizes = $this->size->where('status', 1)->pluck('name', 'id');
        $singleDataColumns = $singleData->getTableColumns();

        // returns array collection // cannot use relation ship // low time
        // $storesData = DB::table('store_products')
        //     ->join('stores', 'store_products.store_id', '=', 'stores.store_id')
        //     ->where('product_id', $id)
        //     ->get();

        // Returns Object Collection // can use relationship // high time
        $storesData = $this->storeProduct
            ->join('stores', 'store_products.store_id', '=', 'stores.store_id')
            ->where('product_id', $id)
            ->with('user')
            ->get();

            // dd($storesData);

        return view('admin.'.$module.'.view',compact('singleData', 'module', 'photos','allData','colors','sizes','productSize', 'singleDataColumns', 'storesData', 'moduleStore'));
    }

    public function source_delete($id)
    {
        $data = $this->data->find($id);
        if($data) {
            $data->update(['video_type'=>NULL, 'video_code'=>NULL]);
            return redirect()->back()->with('success', 'The external source has been deleted successfully.');
        }
        else {
            return redirect()->back()->with('error', 'The external source has not been deleted.');
        }
    }

    public function main_image_delete($id)
    {
        $module = $this->module;
        $data = $this->data->find($id);
        if($data) {
            $this->data->main_image = '';
            Storage::delete($module.'s/images/'.$data->main_image);
            $data->update(['main_image' => NULL]);
            return redirect()->back()->with('success', 'The Main image has been deleted successfully.');
        }
        else {
            return redirect()->back()->with('error', 'The featured main has not been deleted.');
        }
    }

    public function photo_delete($pid)
    {
        $module = $this->module;
        $data = $this->rsrProductPhoto->find($pid);

        if($data) {
            Storage::delete($module.'s/rsr-photos/'.$data->product_id.'/'.$data->image);
            $data->delete();
            return redirect()->back()->with('success', 'The blog photo has been deleted successfully.');
        }
        else {
            return redirect()->back()->with('error', 'The blog photo has not been deleted.');
        }
    }

    public function soft_delete($id)
    {
        // if($this->data->find($id)->delete()) {
        //     return redirect('admin/products/trash')->with('success', 'Your data has been moved to trash');
        // }
        // else {
        //     return redirect()->with('error', 'Your data has not been moved to trash.');
        // }
        
        
        // Get ordered products id
        $orderedItemsData = OrderItem::whereProductId($id)->get()->count();
        // $storeProductsData = $this->storeProduct->whereProductId($id)->get()->count();
        // $displayProductsData = DisplayProduct::whereProductId($id)->get()->count();
        
        if ($orderedItemsData) {
            return redirect('admin/products')->with('error', 'Please delete corresponding orders data.');
        }else{
            $this->data->find($id)->delete();
            return redirect()->back()->with('success', 'Your data has been moved to trash.');
        }
    }

    public function get_restore($id)
    {
        if($this->data->where('id', $id)->withTrashed()->first()->restore()) {
            return redirect()->back()->with('success', 'Your data has been restored.');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been restored.');
        }
    }

    public function force_delete($id)
    {
        $module = $this->module;
        $data = $this->data->where('id', $id)->withTrashed()->first();

        if($data) {
            if($data->main_image){
                Storage::delete($module.'s/images'.$data->main_image);
            }

            $photos = $this->photo->where('product_id', $id)->orderBy('id', 'DESC')->get();
            if(count($photos)>0) {
                $this->photo->where('product_id', $id)->delete();
                Storage::deleteDirectory($module.'s/photos/'.$id);
            }

            $storeProductsData = $this->storeProduct->whereProductId($id)->get()->count();
            $displayProductsData = DisplayProduct::whereProductId($id)->get()->count();

            if ($storeProductsData) {
                 $this->storeProduct->whereProductId($id)->forceDelete();
            }

            if ($displayProductsData) {
                DisplayProduct::whereProductId($id)->forceDelete();
            }
            
            $data->forceDelete();
            return redirect()->back()->with('success', 'Your data has been permanently deleted');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been permanently deleted.');
        }
    }

    public function mark_featured($id)
    {
        $this->data = $this->data->find($id);
        if($this->data->is_featured == 1) {
            $mark = 0;
            $msg = "marked as not featured";
        }
        else{
            $mark = 1;
            $msg = "listed as featured";
        }
        $this->data->is_featured = $mark;
        $this->data->save();

        return redirect()->back()->with('success', 'The product '.$msg);
    }

    // Product Filter
    public function filter_by($filter_type)
    {
        $module = $this->module;
        $deleteCount = $this->data->onlyTrashed()->count();
        $year = date('Y');
        
        
        $categories = $this->category->where('status', 1)->pluck('name', 'id');
        $categorySubs = $this->categorySub->where('status', 1)->pluck('name', 'id');
        $categoryTypes = $this->productCategoryType->where('status', 1)->pluck('name', 'id');
        $brand = $this->brand->where('status', 1)->pluck('name', 'id');

        Session::put('productFilterType', $filter_type);
        if ($filter_type == "disabled-cart") {
            $allData = $this->data
                ->where('is_active_shopping', 0)
                ->orderBy('id', 'DESC')
                ->with(['category', 'user'])
                ->where('created_at', 'like', $year.'%')
                ->paginate(25);
        } elseif($filter_type == "disabled-products") {
            $allData = $this->data
                ->where('status', 0)
                ->orderBy('id', 'DESC')
                ->with(['category', 'user'])
                ->where('created_at', 'like', $year.'%')
                ->paginate(25);
        }else{
            $allData = $this->data
                ->orderBy('id', 'DESC')
                ->with(['category', 'user'])
                ->where('created_at', 'like', $year.'%')
                ->paginate(25);
        }

        return view('admin.'.$module.'.index', compact('allData', 'module', 'deleteCount', 'year', 'categories', 'categorySubs', 'categoryTypes', 'brand'));
    }
}