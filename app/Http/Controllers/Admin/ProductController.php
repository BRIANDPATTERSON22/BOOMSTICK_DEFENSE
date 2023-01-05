<?php namespace App\Http\Controllers\Admin;

use App\Color;
use App\DisplayProduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductColorRequest;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Requests\Admin\ProductSizeRequest;
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

class ProductController extends Controller
{
    public function __construct(Product $product, ProductCategory $category, ProductCategorySub $categorySub, ProductPhoto $photo, ProductBrand $brand, ProductModel $model, ProductColor $productColor, Color $color, ProductCategoryType $productCategoryType, Size $size, ProductSize $productSize, Store $store, StoreProduct $storeProduct, StoreCategory $storeCategory, ProductHasRelatedProduct $productHasRelatedProduct)
    {
        $this->module = "product";
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

        $this->option = Cache::get('optionCache');
        $this->middleware('auth');
    }

    public function get_index()
    {
        Session::forget('filterBrand');
        Session::forget('searchText');

        $year = date('Y');
        $module = $this->module;
        $deleteCount = $this->data->onlyTrashed()->count();

        $allData = $this->data->orderBy('id', 'DESC')
            ->with(['category', 'user', 'brand'])
            // ->where('created_at', 'like', $year.'%')
            ->paginate(20);

        $categories = $this->category->where('status', 1)->pluck('name', 'id');
        $categorySubs = $this->categorySub->pluck('name', 'id');
        $categoryTypes = $this->productCategoryType->where('status', 1)->pluck('name', 'id');
        $brand = $this->brand->where('status', 1)->pluck('name', 'id');

        return view('admin.'.$module.'.index', compact('allData', 'module', 'deleteCount', 'year','categories', 'categorySubs', 'categoryTypes', 'brand'));
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

        $this->data->fill($request->all());

        // if($request->youtube && (stripos($request->youtube, "youtube") === false)){
        //     return redirect()->back()->with('error', 'Invalid youtube url');
        // }

        $slug = str_slug($request->title);
        $existingSlugs = $this->data->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->data->slug =$slug.'-'.$existingSlugs : $this->data->slug = $slug;

        $this->data->main_category_id = $request->category_main_id;
        $this->data->sub_category_id = $request->category_id;
        $this->data->user_id = Auth::id();
        $this->data->dicounted_price = $request->retail_price - ( ($request->discount_percentage / 100) * $request->retail_price);
        // $request->is_firearm == 1 ? $this->data->is_firearm = 1 : $this->data->is_firearm = 0;
        $request->is_retail_price_enabled == null || $request->is_retail_price_enabled == 1 ? $this->data->is_retail_price_enabled = 1 : $this->data->is_retail_price_enabled = 0;
        $request->is_purchase_enabled == null || $request->is_purchase_enabled == 1 ? $this->data->is_purchase_enabled = 1 : $this->data->is_purchase_enabled = 0;
        $this->data->status = 1;


        if($request->main_image) {
            $file = $request->main_image;
            Image::make($file)->widen(512, function ($constraint) {$constraint->upsize(); })->crop(512,512)->fill('#ffffff', 0, 0)->save($file);
            $filename2= time().'.'.$file->getClientOriginalExtension();
            $filepath = $module.'s/images/'.$filename2;
            Storage::put($filepath, file_get_contents($file), 'public');
            $this->data->main_image = $filename2;
        }

        if($request->banner_image) {
            $fileBannerImage = $request->banner_image;
            // Image::make($fileBannerImage)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($fileBannerImage);
            Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->crop(1024,350)->fill('#ffffff', 0, 0)->save($file);
            $bannerImage= time().'.'.$fileBannerImage->getClientOriginalExtension();
            $filepath = $module.'s/banner-images/'.$bannerImage;
            Storage::put($filepath, file_get_contents($fileBannerImage), 'public');
            $this->data->banner_image = $bannerImage;
        }

        $this->data->save();
        $dataId = $this->data->id;

        // --Product Gallery--
        $files = Input::file('photo.image');
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

        //--Assign Related Products--
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

        $singleData = $this->data->find($id);
        $photos = $this->photo->where('product_id', $id)->get();

        $categories = $this->category->pluck('name', 'id');
        $categorySubs = $this->categorySub->where('status', 1)->pluck('name', 'id');
        // $categoryTypes = $this->productCategoryType->where('status', 1)->pluck('name', 'id');
        $brand = $this->brand->where('status', 1)->pluck('name', 'id');
        $model = $this->model->where('status', 1)->pluck('name', 'id');
        // $sizesDescription = $this->size->where('status', 1)->pluck('name', 'id');
        // $sizesMeasurement = $this->size->where('status', 1)->pluck('measurement_type', 'id');
        $colors = $this->color->where('status', 1)->pluck('name', 'id');
        // $parentProducts = $this->data->where('status', 1)->pluck('name', 'id');

        // $sizeWithSymbol = $this->size->select('id', DB::raw("concat(name, ' - ',measurement_type) as id_name"))
        //                 ->orderBy('name')
        //                 ->pluck('id_name', 'id');

        // $oldStores = $this->storeProduct->where('product_id', $id)->pluck('store_id')->toArray();
        // $singleData->stores = $oldStores;

        // $pluckStorsData = $this->store->where('status', 1)->pluck('banner', 'store_id');
        // $pluckStorsData = $this->store->where('status', 1)->select('city', 'store_id')->get();

        // $storeCategoriesData = $this->storeCategory->where('status', 1)->pluck('title', 'id');

        // $pluckStorsData = $this->store->select('store_id', 'division', DB::raw("concat(banner, ' - ',store_id) as store_info"))
        //                 ->orderBy('division')
        //                 ->pluck('store_info', 'store_id');

        // $storeCategoriesData = $this->storeCategory->where('status', 1)->select('id', 'title')->with('storesData')->get();

        $relatedProducts = $this->data->where('status', 1)->select('id', 'title')->get();

        $oldRelatedProducts = $this->productHasRelatedProduct->where('product_id', $id)->pluck('related_product_id')->toArray();
        $singleData->related_products = $oldRelatedProducts;

        return view('admin.'.$module.'.add_edit',compact('singleData', 'photos', 'module', 'brand', 'model', 'colors', 'relatedProducts', 'categories', 'categorySubs'));
    }

    public function post_edit(ProductRequest $request, $id)
    {
        $module = $this->module;

        $this->data = $this->data->find($id);

        $oldMainImageName = $filename2 = $this->data->main_image;
        $oldBannerImageName = $bannerImageName = $this->data->banner_image;

        $this->data->fill($request->all());

        //Image upload function
        if($request->main_image) {
            $file = $request->main_image;
            // Image::make($file)->widen(512, function ($constraint) {$constraint->upsize(); })->crop(309,400)->save($file);
            Image::make($file)->widen(400, function ($constraint) {$constraint->upsize(); })->crop(400,400)->fill('#ffffff', 0, 0)->save($file);
            $filename2 = time().'.'.$file->getClientOriginalExtension();
            $filepath = $module.'s/images/'.$filename2;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldMainImageName)
                Storage::delete($module.'s/images/'.$oldMainImageName);
        }

        //Banner Image upload function
        if($request->banner_image) {
            $fileBannerImage = $request->banner_image;
            // Image::make($file)->widen(512, function ($constraint) {$constraint->upsize(); })->crop(309,400)->save($file);
            Image::make($fileBannerImage)->widen(1024, function ($constraint) {$constraint->upsize(); })->crop(1024,350)->fill('#ffffff', 0, 0)->save($fileBannerImage);
            $bannerImageName = time().'.'.$fileBannerImage->getClientOriginalExtension();
            $filepath = $module.'s/banner-images/'.$bannerImageName;
            Storage::put($filepath, file_get_contents($fileBannerImage), 'public');
            if($oldBannerImageName)
                Storage::delete($module.'s/banner-images/'.$oldBannerImageName);
        }

        $this->data->slug = str_slug($request->slug);
        $this->data->main_image = $filename2;
        $this->data->banner_image = $bannerImageName;
        $this->data->user_id = Auth::id();
                
        $this->data->main_category_id = $request->category_main_id;
        $this->data->sub_category_id = $request->category_id;

        $this->data->dicounted_price = $request->retail_price - ( ($request->discount_percentage / 100) * $request->retail_price);
        // $request->is_firearm == 1 ? $this->data->is_firearm = 1 : $this->data->is_firearm = 0;
        // $request->is_purchase_enabled == 1 ? $this->data->is_purchase_enabled = 1 : $this->data->is_purchase_enabled = 0;
        // $request->is_retail_price_enabled == 1 ? $this->data->is_retail_price_enabled = 1 : $this->data->is_retail_price_enabled = 0;
        $request->status == 1 ? $this->data->status = 1 : $this->data->status = 0;
        $this->data->save();

        //--Product Gallery--
        $files = Input::file('photo.image');
        $photos = $this->photo->where('product_id', $id)->orderBy('order', 'DESC')->get();
        //Multiple image upload
        // if(count($files)> 0){
        if($files){
            $images = null;
            count($photos)>0 ? $i = $photos[0]->order : $i = 1;
            foreach ($files as $file) {
                $i++;
                // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
                Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->crop(1024,1024)->fill('#ffffff', 0, 0)->save($file);

                // $background = Image::canvas(622, 800)->fill('#fffff', 0, 0);
                // $image = Image::make($file)->resize(622, 800, function ($c) {
                //     $c->aspectRatio();
                //     $c->upsize();
                // });
                // $background->insert($image, 'center')->save($file);

                $filename = $i.'_'.time().'.'.$file->getClientOriginalExtension();
                $filepath = $module.'s/photos/'.$id.'/'.$filename;
                $upload_success = Storage::put($filepath, fopen($file, 'r+'), 'public');
                if($upload_success) {
                    $images[] = [
                        'order' => $i,
                        'image' => $filename,
                        'product_id' => $id,
                        'created_at' => new DateTime,
                        'updated_at' => new DateTime,
                    ];
                }
            }
            if($images) {
                $this->photo->insert($images);
            }
            //Update photo caption
            foreach ($photos as $row) {
                $title = $row->id . 'title';
                $row->title = $request->$title;
                $row->save();
            }
        }


        //--Assign Related Products--
        $oldRelatedProducts = $this->productHasRelatedProduct->where('product_id', $id)->pluck('related_product_id')->toArray();
        $availableRelatedProducts = null;
        if($request->related_products) {
            foreach ($request->related_products as $newRelatedProduct) {
                if (!in_array($newRelatedProduct, $oldRelatedProducts)) {
                    $availableRelatedProducts[] = [
                        'product_id' => $id,
                        'related_product_id' => $newRelatedProduct,
                        'created_at' => new DateTime,
                        'updated_at' => new DateTime,
                    ];
                } else {
                    $key = array_search($newRelatedProduct, $oldRelatedProducts);
                    unset($oldRelatedProducts[$key]);
                }
            }
        }
        if($availableRelatedProducts) {
            $this->productHasRelatedProduct->insert($availableRelatedProducts);
        }
        //Delete old related products
        $this->productHasRelatedProduct->whereIn('related_product_id', $oldRelatedProducts)->where('product_id', $id)->forceDelete();

        return redirect()->back()->with('success', 'Data '.$this->data->name.' has been updated');
    }

    public function get_view($id)
    {
        $module = $this->module;
        $moduleStore = 'store';

        $singleData = $this->data->find($id);
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
            $data->update(['youtube' => NULL]);
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
        $data = $this->photo->find($pid);
        if($data) {
            Storage::delete($module.'s/photos/'.$data->product_id.'/'.$data->image);
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

    // Add Color to products
    public function post_price($prid, Request $request)
    {
        $product = $this->data->where('id', $prid)->first();

        $this->productColor->fill($request->all());
        $this->productColor->product_id = $product->id;
        $this->productColor->status = 1;
        $this->productColor->save();

        return redirect()->back()->with('success', 'Your data has been permanently deleted');
    }

    public function get_price_view($id)
    {
        $module = $this->module;
        $priceSingleData = $this->productColor->find($id);
        return view('admin.'.$module.'.view',compact('priceSingleData', 'module'));
    }

    public function get_price_edit(Request $request, $prid, $id)
    {
        $product = $this->data->where('id', $prid)->first();

        $this->productColor = $this->productColor->find($id);
        $this->productColor->fill($request->all());
        $request->status == 1 ? $this->productColor->status = 1 : $this->productColor->status = 0;
        $this->productColor->save();

        return redirect()->back()->with('success', 'Your data has been permanently deleted');
    }

    public function price_soft_delete(Request $request,$id)
    {
        if($this->productColor->find($id)->delete()) {
            return redirect()->back()->with('success', 'Your data has been moved to trash');
        }
        else {
            return redirect()->with('error', 'Your data has not been moved to trash.');
        }
    }

    public function get_price_trash()
    {
        $module = $this->module;
        $allData = $this->productColor->onlyTrashed()->get();

        return view('admin.'.$module.'.index', compact('allData', 'module'));
    }

    public function price_get_restore($id)
    {
        if($this->productColor->where('id', $id)->withTrashed()->first()->restore()) {
            return redirect()->back()->with('success', 'Your data has been restored.');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been restored.');
        }
    }

    public function price_force_delete($id)
    {
        $module = $this->module;
        $data = $this->productColor->where('id', $id)->withTrashed()->first();

        if($data) {
            $data->forceDelete();
            return redirect()->back()->with('success', 'Your data has been permanently deleted');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been permanently deleted.');
        }
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

    /**
     * Manage single product size
     */
    public function post_size($prid, Request $request)
    {
        $product = $this->data->where('id', $prid)->first();

        $this->productSize->fill($request->all());
        $this->productSize->product_id = $product->id;
        $this->productSize->price = $request->price;
        $this->productSize->sku = $product->sku;
        $this->productSize->status = 1;
        $this->productSize->save();

        return redirect()->back()->with('success', 'Your data has been added!');
    }

    public function get_size_edit(Request $request, $prid, $id)
    {
        $product = $this->data->where('id', $prid)->first();

        $this->productSize = $this->productSize->find($id);
        $this->productSize->fill($request->all());
        $this->productSize->price = $request->price;
        $this->productSize->sku = $product->sku;
        $request->status == 1 ? $this->productSize->status = 1 : $this->productSize->status = 0;
        $this->productSize->save();

        return redirect()->back()->with('success', 'Your data has been updated!');
    }

    public function size_soft_delete(Request $request,$id)
    {
        if($this->productSize->find($id)->delete()) {
            return redirect()->back()->with('success', 'Your data has been moved to trash');
        }
        else {
            return redirect()->with('error', 'Your data has not been moved to trash.');
        }
    }

    public function get_size_trash()
    {
        $module = $this->module;
        $allData = $this->productSize->onlyTrashed()->get();

        return view('admin.'.$module.'.index', compact('allData', 'module'));
    }

    public function size_get_restore($id)
    {
        if($this->productSize->where('id', $id)->withTrashed()->first()->restore()) {
            return redirect()->back()->with('success', 'Your data has been restored.');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been restored.');
        }
    }

    public function size_force_delete($id)
    {
        $module = $this->module;
        $data = $this->productSize->where('id', $id)->withTrashed()->first();

        if($data) {
            $data->forceDelete();
            return redirect()->back()->with('success', 'Your data has been permanently deleted');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been permanently deleted.');
        }
    }

    public function get_size_view($id)
    {
        $module = $this->module;
        $priceSingleData = $this->productSize->find($id);
        return view('admin.'.$module.'.view',compact('priceSingleData', 'module'));
    }

    public function post_filter_product_by_category(Request $request)
    {
        $mainCategoryID = $request->category_main_id;
        $subCategoryID = $request->category_id;
        $subCategoryTypeID = $request->sub_category_type_id;

        if($mainCategoryID && $subCategoryID && $subCategoryTypeID) {
            return redirect('admin/filter/' . $mainCategoryID . '/' . $subCategoryID . '/' . $subCategoryTypeID);
        }elseif($mainCategoryID && $subCategoryID) {
            return redirect('admin/filter/y-' . $mainCategoryID . '/b-' . $subCategoryID);
        }elseif($mainCategoryID && $subCategoryTypeID){
            return redirect('admin/filter/y-'.$mainCategoryID.'/m-'.$subCategoryTypeID);
        }elseif($subCategoryID && $subCategoryTypeID){
            return redirect('admin/filter/b-'.$subCategoryID.'/m-'.$subCategoryTypeID);
        }elseif($mainCategoryID){
            return redirect('admin/filter/y-'.$mainCategoryID);
        }elseif($subCategoryID){
            return redirect('admin/filter/b-'.$subCategoryID);
        }elseif($subCategoryTypeID){
            return redirect('admin/filter/m-'.$subCategoryTypeID);
        }else{
            return redirect('admin/products');
        }
    }

    public function get_filter1_y($mainCategoryID)
    {
        Session::forget('filterSubCategory');
        Session::forget('filterSubCategoryType');

        Session::put('filterMainCategory', $mainCategoryID);
       
        $module = $this->module;
        $year = date('Y');

        $categories = $this->category->where('status', 1)->pluck('name', 'id');
        $categorySubs = $this->categorySub->where('status', 1)->pluck('name', 'id');
        $categoryTypes = $this->productCategoryType->where('status', 1)->pluck('name', 'id');
        $brand = $this->brand->where('status', 1)->pluck('name', 'id');

        $allData = $this->data
                ->where('status', 1)
                ->whereHas('category', function($query) use($mainCategoryID) {
                   $query->where('category_id', '=', $mainCategoryID);
                })
                ->paginate(20);

        if(count($allData)>0) {
            return view('admin.'.$module.'.index', compact('allData', 'module', 'year', 'categories', 'categorySubs', 'categoryTypes','brand'));
        }else{
            return redirect()->back()->with('error', 'No data found');
        }
    }

    public function get_filter1_b($subCategoryID)
    {
        Session::forget('filterMainCategory');
        Session::forget('filterSubCategoryType');

        Session::put('filterSubCategory', $subCategoryID);

        $module = $this->module;
        $year = date('Y');

        $categories = $this->category->where('status', 1)->pluck('name', 'id');
        $categorySubs = $this->categorySub->where('status', 1)->pluck('name', 'id');
        $categoryTypes = $this->productCategoryType->where('status', 1)->pluck('name', 'id');
        $brand = $this->brand->where('status', 1)->pluck('name', 'id');

         $allData = $this->data
                ->where('status', 1)
                ->Where('category_id', $subCategoryID)
                ->paginate(20);

        if(count($allData)>0) {
            return view('admin.'.$module.'.index', compact('allData', 'module', 'year', 'categories', 'categorySubs', 'categoryTypes','brand'));
        }else{
            return redirect()->back()->with('error', 'No data found');
        }
    }

    public function get_filter1_m($subCategoryTypeID)
    {
        Session::forget('filterMainCategory');
        Session::forget('filterSubCategory');

        Session::put('filterSubCategoryType', $subCategoryTypeID);

        $module = $this->module;
        $year = date('Y');

        $categories = $this->category->where('status', 1)->pluck('name', 'id');
        $categorySubs = $this->categorySub->where('status', 1)->pluck('name', 'id');
        $categoryTypes = $this->productCategoryType->where('status', 1)->pluck('name', 'id');
        $brand = $this->brand->where('status', 1)->pluck('name', 'id');

        $allData = $this->data
            ->where('status', 1)
            ->Where('sub_category_type_id', $subCategoryTypeID)
            ->paginate(20);

        if(count($allData)>0) {
            return view('admin.'.$module.'.index', compact('allData', 'module', 'year', 'categories', 'categorySubs', 'categoryTypes','brand'));
        }else{
            return redirect()->back()->with('error', 'No data found');
        }
    }

    public function get_filter2_yb($mainCategoryID, $subCategoryID)
    {
        Session::forget('filterSubCategoryType');

        Session::put('filterMainCategory', $mainCategoryID);
        Session::put('filterSubCategory', $subCategoryID);

        $module = $this->module;
        $year = date('Y');

        $categories = $this->category->where('status', 1)->pluck('name', 'id');
        $categorySubs = $this->categorySub->where('status', 1)->pluck('name', 'id');
        $categoryTypes = $this->productCategoryType->where('status', 1)->pluck('name', 'id');
        $brand = $this->brand->where('status', 1)->pluck('name', 'id');

        $allData = $this->data
            ->where('status', 1)
            ->whereHas('category', function($query) use($mainCategoryID, $subCategoryID) {
               $query->where('category_id', '=', $mainCategoryID);
            })
            ->Where('category_id', $subCategoryID)
            ->paginate(20);

        if(count($allData)>0) {
            return view('admin.'.$module.'.index', compact('allData', 'module', 'year', 'categories', 'categorySubs', 'categoryTypes','brand'));
        }else{
            return redirect()->back()->with('error', 'No data found');
        }
    }
    public function get_filter2_ym($mainCategoryID, $subCategoryTypeID)
    {
        Session::forget('filterSubCategory');

        Session::put('filterMainCategory', $mainCategoryID);
        Session::put('filterSubCategoryType', $subCategoryTypeID);

        $module = $this->module;
        $year = date('Y');

        $categories = $this->category->where('status', 1)->pluck('name', 'id');
        $categorySubs = $this->categorySub->where('status', 1)->pluck('name', 'id');
        $categoryTypes = $this->productCategoryType->where('status', 1)->pluck('name', 'id');
        $brand = $this->brand->where('status', 1)->pluck('name', 'id');

        $allData = $this->data
            ->where('status', 1)
            ->whereHas('category', function($query) use($mainCategoryID) {
               $query->where('category_id', '=', $mainCategoryID);
            })
            ->Where('sub_category_type_id', $subCategoryTypeID)
            ->paginate(20);

        if(count($allData)>0) {
            return view('admin.'.$module.'.index', compact('allData', 'module', 'year', 'categories', 'categorySubs', 'categoryTypes','brand'));
        }else{
            return redirect()->back()->with('error', 'No data found');
        }
    }

    public function get_filter2_bm($subCategoryID, $subCategoryTypeID)
    {
        Session::forget('filterMainCategory');

        Session::put('filterSubCategory', $subCategoryID);
        Session::put('filterSubCategoryType', $subCategoryTypeID);

        $module = $this->module;
        $year = date('Y');

        $categories = $this->category->where('status', 1)->pluck('name', 'id');
        $categorySubs = $this->categorySub->where('status', 1)->pluck('name', 'id');
        $categoryTypes = $this->productCategoryType->where('status', 1)->pluck('name', 'id');
        $brand = $this->brand->where('status', 1)->pluck('name', 'id');

        $allData = $this->data
            ->where('status', 1)
            ->Where('category_id', $subCategoryID)
            ->Where('sub_category_type_id', $subCategoryTypeID)
            ->paginate(20);

        if(count($allData)>0) {
            return view('admin.'.$module.'.index', compact('allData', 'module', 'year', 'categories', 'categorySubs', 'categoryTypes','brand'));
        }else{
            return redirect()->back()->with('error', 'No data found');
        }
    }

    public function get_filter3($mainCategoryID, $subCategoryID, $subCategoryTypeID)
    {
        Session::put('filterMainCategory', $mainCategoryID);
        Session::put('filterSubCategory', $subCategoryID);
        Session::put('filterSubCategoryType', $subCategoryTypeID);

        $module = $this->module;
        $year = date('Y');

        $categories = $this->category->where('status', 1)->pluck('name', 'id');
        $categorySubs = $this->categorySub->where('status', 1)->pluck('name', 'id');
        $categoryTypes = $this->productCategoryType->where('status', 1)->pluck('name', 'id');
        $brand = $this->brand->where('status', 1)->pluck('name', 'id');

        $allData = $this->data
            ->where('status', 1)
            ->whereHas('category', function($query) use($mainCategoryID) {
               $query->where('category_id', '=', $mainCategoryID);
            })
            ->Where('category_id', $subCategoryID)
            ->Where('sub_category_type_id', $subCategoryTypeID)
            ->paginate(50);

        if(count($allData)>0) {
            return view('admin.'.$module.'.index', compact('allData', 'module', 'year', 'categories', 'categorySubs', 'categoryTypes','brand'));
        }else{
            return redirect()->back()->with('error', 'No data found');
        }
    }

    public function post_brand(Request $request)
    {
        $brandId = $request->brand_id;

        if($brandId){
            return redirect('admin/products/brands/'.$brandId)->with('success', session('filterBrandName').' '.'brand'.' '.'Products.');
        }else{
            return redirect()->back()->with('error', 'Please, Select a brand.');
        }
    }

    public function get_filter_brand($brandId)
    {
        Session::put('filterBrand', $brandId);
        Session::forget('searchText');

        $brandName = $this->brand->findOrFail($brandId)->name;
        Session::put('filterBrandName', $brandName);

        $module = $this->module;
        $year = date('Y');

        $categories = $this->category->where('status', 1)->pluck('name', 'id');
        $categorySubs = $this->categorySub->where('status', 1)->pluck('name', 'id');
        $categoryTypes = $this->productCategoryType->where('status', 1)->pluck('name', 'id');
        $brand = $this->brand->where('status', 1)->pluck('name', 'id');

        $allData = $this->data
            ->with(['category', 'user', 'brand'])
            ->where('status', 1)
            ->where('brand_id', $brandId)
            ->paginate(20);

        if(count($allData)>0) {
            return view('admin.'.$module.'.index', compact('allData', 'module', 'year', 'categories', 'categorySubs', 'categoryTypes','brand'));
        }else{
            return redirect()->back()->with('error', 'No data found');
        }
    }

    public function post_search_by_word(Request $request)
    {
        $searchText = $request->searchText;

        if($searchText){
            return redirect('admin/products/product/'.$searchText)->with('success', 'Search Result for :' .' ' .session('searchText'));
        }else{
            return redirect()->back()->with('error', 'Please, Enter any product details (Name, SKU, Description).');
        }
    }

    public function get_filter_product($searchText)
    {   
        Session::forget('filterBrand');
        Session::put('searchText', $searchText);

        $module = $this->module;
        $year = date('Y');

        $categories = $this->category->where('status', 1)->pluck('name', 'id');
        $categorySubs = $this->categorySub->where('status', 1)->pluck('name', 'id');
        $categoryTypes = $this->productCategoryType->where('status', 1)->pluck('name', 'id');
        $brand = $this->brand->where('status', 1)->pluck('name', 'id');

        $allData = $this->data->where('status', 1)
            ->where('title', 'like', '%' .$searchText. '%')
            // ->orWhere('description', 'like', '%' .$searchText. '%')
            // ->orWhere('content', 'like', '%' .$searchText. '%')
            ->orWhere('upc', 'like', '%' .$searchText. '%')
            ->orWhere('product_id', 'like', '%' .$searchText. '%')
            ->paginate(20);

        if(count($allData)>0) {
            return view('admin.'.$module.'.index', compact('allData', 'module', 'year', 'categories', 'categorySubs', 'categoryTypes','brand'));
        }else{
            return redirect()->back()->with('error', 'No data found for your search keyword: '.$searchText);
        }
    }

}