<?php namespace App\Http\Controllers\Site;

use App\Advertisement;
use App\Http\Controllers\Controller;
use App\OccasionProduct;
use App\Product;
use App\ProductBrand;
use App\ProductCategory;
use App\ProductCategorySub;
use App\ProductColor;
use App\ProductHasRelatedProduct;
use App\ProductPhoto;
use App\ProductReview;
use App\ProductSize;
use App\ProductView;
use App\RsrMainCategory;
use App\RsrProducAttribute;
use App\RsrProduct;
use App\RsrSubCategory;
use App\SalesPerson;
use App\Size;
use App\Store;
use App\StoreCategory;
use App\StoreProduct;
use DB;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function __construct(ProductCategory $category, ProductCategorySub $categorySub, Product $product, ProductPhoto $photo, ProductView $view, ProductColor $productColor, ProductBrand $productBrand, Advertisement $advertisement,  ProductReview $review, Size $size, ProductSize $productSize, OccasionProduct $occasionProduct, Store $store, StoreProduct $storeProduct, StoreCategory $storeCategory, SalesPerson $salesPerson, ProductHasRelatedProduct $productHasRelatedProduct, RsrProduct $rsrProduct, RsrMainCategory $rsrCategory, RsrSubCategory $rsrSubCategory, RsrProducAttribute $rsrProducAttribute)
    {
        $this->module = "product";
        $this->data = $product;
        $this->category = $category;
        $this->categorySub = $categorySub;
        $this->photo = $photo;
        $this->view = $view;
        $this->productColor = $productColor;
        $this->productBrand = $productBrand;
        $this->advertisement = $advertisement;
        $this->review = $review;
        $this->size = $size;
        $this->productSize = $productSize;
        $this->occasionProduct = $occasionProduct;
        $this->store = $store;
        $this->storeProduct = $storeProduct;
        $this->storeCategory = $storeCategory;
        $this->salesPerson = $salesPerson;
        $this->productHasRelatedProduct = $productHasRelatedProduct;

        $this->rsrProduct = $rsrProduct;
        $this->rsrCategory = $rsrCategory;
        $this->rsrSubCategory = $rsrSubCategory;
        $this->rsrProducAttribute = $rsrProducAttribute;
        $this->middleware('guest');
    }

    public function get_products()
    {
        $module = $this->module;
        
        $categoriesData = $this->category->where('status', 1)->get();
        $rsrCategoriesData = $this->rsrCategory->orderBY('department_name', 'ASC')->get();

        if (count(request()->all()) > 0) {
            if (request()->q) {
                $allData = $this->data
                    ->where('status', 1)
                    ->whereHas('rel_main_category', function($query) {
                       $query->where('status', 1);
                    })
                    ->where('title', 'like', '%' .request()->q. '%')
                    ->OrWhere('short_description', 'like', '%' .request()->q. '%')
                    ->OrWhere('content', 'like', '%' .request()->q. '%')
                    ->orderBy('title','ASC')
                    ->paginate(28);
            }else{
                // $allData = $this->data
                //     ->where('status', 1)
                //     ->whereHas('rel_main_category', function($query) {
                //        $query->where('status', 1);
                //     })
                //     ->orderBy('title','ASC')
                //     ->paginate(28);
                    $allData = collect([]);
                }

            $allDataBuilder = RsrProduct::query();

            // ---
            $sText = substr(request()->q, 0, 1) == 0 ? substr(request()->q, 1) : request()->q;
            request()->q ? 
                $allDataBuilder
                ->orWhere('rsr_stock_number', 'like', '%' .request()->q. '%')
                // ->orWhere('upc_code', 'like', '%' .request()->q. '%')
                // ->orWhere('upc_code', 'like', '%' .substr(request()->q, 0, 1) == 0 ? substr(request()->q, 1) : request()->q. '%')
                ->orWhere('upc_code', 'like', '%' .$sText. '%')
                ->orWhere('product_description', 'like', '%' .request()->q. '%')
                ->orWhere('full_manufacturer_name', 'like', '%' .request()->q. '%')
                ->orWhere('model', 'like', '%' .request()->q. '%')
                ->orWhere('manufacturer_part_number', 'like', '%' .request()->q. '%')
                ->orWhere('expanded_product_description', 'like', '%' .request()->q. '%')
                ->get() 
                : null; 

            // ---
            request()->category_ids ? $allDataBuilder->whereIn('department_number', request()->category_ids)->get() : null;

            // --
            request()->stock_availability ? $allDataBuilder->where('inventory_quantity', '>', request()->stock_availability)->get() : null;

            // --- --- ---
            $from_price = (int)request()->from_price;
            $to_price = (int)request()->to_price;
            if ($from_price && $to_price) {
                 $allDataBuilder->where('retail_price', '>=', $from_price)
                    ->where('retail_price', '<=', $to_price)
                    ->get();
            }elseif($from_price){
                $allDataBuilder->where('retail_price', $from_price)->get();
            }elseif($to_price){
                $allDataBuilder->where('retail_price', $to_price)->get();
            }

            // --- --- ---
            $retailPrice = "CAST(retail_price AS DECIMAL(10,2)) ASC";
            if (request()->sort_by == "low_to_high") {
                $allDataBuilder->orderByRaw($retailPrice, 'ASC')->get();
            }elseif(request()->sort_by == "high_to_low"){
                $allDataBuilder->orderByRaw("CAST(retail_price AS DECIMAL(10,2)) DESC")->get();
                // $allDataBuilder->orderBy('retail_price', 'desc')->get();
            }elseif(request()->sort_by == "available_quantity"){
                $allDataBuilder->orderByRaw("CAST(inventory_quantity AS DECIMAL(10)) DESC")->where('inventory_quantity', '>', 0)->get();
                // $allDataBuilder->orderBy('inventory_quantity', 'ASC')->get();
            }else{
                $allDataBuilder->orderBy('product_description', 'ASC')->get();
            }

            $rsrProductsData = $allDataBuilder->orderBy('id', 'ASC')->with('rsr_attribute')->paginate(request()->products_per_page?? 24)->appends([
                'q' => request()->q,
                'category_ids' => request()->category_ids,
                'stock_availability' => request()->stock_availability,
                'from_price' => request()->from_price,
                'to_price' => request()->to_price,
                'products_per_page' => request()->products_per_page,
                'sort_by' => request()->sort_by,
            ]);
        }else{
            $allData = $this->data
                ->where('status', 1)
                ->whereHas('rel_main_category', function($query) {
                   $query->where('status', 1);
                })
                ->orderBy('title','ASC')
                ->paginate(24);

            $rsrProductsData = $this->rsrProduct
                ->whereHas('rsr_category', function($query) {
                    $query->where('status', 1);
                })
                ->orderBy('product_description','ASC')
                ->paginate(24);
            }

        return view('site.'.$module.'.index', compact('allData','module', 'categoriesData', 'rsrProductsData', 'rsrCategoriesData'));
    }

    public function get_sort($sort)
    {
        // $dt = Carbon::now();
        $dt = new DateTime();
        $module = $this->module;
        Session::put('sortBy', $sort);
        if($sort == "view") {
            $allData = $this->data->where('status', 1)->withCount('views')->orderBy('views_count', 'DESC')->paginate(18);
        }
        elseif($sort == "sale") {
            $allData = $this->data->where('status', 1)->withCount('sales')->orderBy('sales_count', 'DESC')->paginate(18);
        }
        elseif($sort == "date") {
            $allData = $this->data->where('status', 1)->orderBy('created_at', 'DESC')->paginate(18);
        }
        elseif($sort == "offer") {
            $allData = $this->data->where('status', 1)->where('offer_ended_at', '>=',  $dt)->paginate(18);
        }
        elseif($sort == "featured-products") {
            $allData = $this->data
            	->where('status', 1)
            	->whereHas('category', function($query) {
                   $query->where('status', 1);
                })
            	->where('display', '1')
            	->paginate(18);
        }
        elseif($sort == "low-to-high") {
            $allData = $this->data
            	->where('status', 1)
            	->whereHas('category', function($query) {
                   $query->where('status', 1);
                })
            	->orderBy('price', 'ASC')
            	->paginate(18);
        }
        elseif($sort == "high-to-low") {
            $allData = $this->data
            	->where('status', 1)
            	->whereHas('category', function($query) {
                   $query->where('status', 1);
                })
            	->orderBy('price', 'DESC')
            	->paginate(18);
        }
        elseif($sort == "new-products") {
              $allData = $this->data
              	->where('status', 1)
              	->whereHas('category', function($query) {
              		$query->where('status', 1);
                  })
              	->orderBy('created_at','DESC')
              	->limit(50)
              	->get();
        }
        else{
            $allData = $this->data
            	->whereHas('category', function($query) {
                   $query->where('status', 1);
                })
            	->where('status', 1)
            	->paginate(12);
        }

        return view('site.'.$module.'.index', compact('allData','module'));
    }

    public function get_single_product($id)
    {
        $module = $this->module;
        $rsrCategoriesData = $this->rsrCategory->orderBY('department_name', 'ASC')->get();

        $singleData = $this->data->where('slug', $id)->first();

        if($singleData)
        {
            $photos = $this->photo->where('product_id', $singleData->id)->limit(10)->get();

            $otherData = $this->data
                ->where('id', '!=', $id)
                ->where('status', 1)
                ->inRandomOrder()
                ->limit(12)
                ->get();

            return view('site.'.$module.'.single',compact('singleData', 'module', 'photos', 'otherData'));
        }
        else{
            $singleData = $this->rsrProduct->where('rsr_stock_number', $id)->first();

            if (!$singleData) {
                return view('site.errors.404');
            }
            
            $photos = $this->photo->where('product_id', $singleData->id)->limit(10)->get();
            $otherData = $this->rsrProduct
                ->where('rsr_stock_number', '!=', $id)
                ->inRandomOrder()
                ->limit(12)
                ->get();

            // dump($singleData->all_related_products);
            
            return view('site.'.$module.'.single_rsr',compact('singleData', 'module', 'photos', 'otherData'));
        }
    }

    public function get_product_catalog($id)
    {
        $module = $this->module;
        $singleData = $this->data->where('slug', $id)->first();

        if($singleData) {
            $photos = $this->photo->where('product_id', $singleData->id)->limit(5)->get();
            return view('site.'.$module.'.catalog',compact('singleData', 'module', 'photos'));
        }
        else{
            return view('site.errors.404');
        }
    }

    public function get_categories($slug)
    {
        $module = $this->module;
        $categoriesData = $this->category->where('status', 1)->get();

        $subCat = $this->categorySub->where('slug', $slug)->where('status', 1)->first();
        if($subCat) {
            $catIds = [$subCat->id];
            $category = $subCat;
        }
        else {
            $mainCat = $this->category->where('slug', $slug)->where('status', 1)->first();
            if($mainCat) {
                $catIds = $this->categorySub->where('category_id', $mainCat->id)->pluck('id')->toArray();
                $category = $mainCat;
            }
        }

        // if($catIds){
            // $allData = $this->data->whereIn('category_id', $catIds)->where('status', 1)->groupBy('parent_product_id')->paginate(12);
            $allData = $this->data->whereIn('category_id', $catIds)->where('status', 1)->paginate(12);
            return view('site.'.$module.'.index', compact('allData', 'category', 'categoriesData'));
        // }
        // else{
            // return view('site.errors.404');
        // }
    }

    public function get_single($category, $id)
    {
        $module = $this->module;

        $singleData = $this->data->find($id);
        $otherData = $this->data->where('id', '!=', $id)->where('status', 1)->orderBy('id', 'DESC')->limit(5)->get();

        //Update view count
        // $ip = \Illuminate\Support\Facades\Request::getClientIp();
        // if ($this->view->where('ip', $ip)->where('product_id', $id)->first()){}
        // else{
        //     $this->view->product_id = $id;
        //     $this->view->ip = $ip;
        //     $this->view->save();
        // }
        
        $ip = \Illuminate\Support\Facades\Request::getClientIp();
        $exist = $this->view->where('ip', $ip)->where('product_id', $id)->first();
        if(!$exist) {
            $this->view->product_id = $id;
            $this->view->ip = $ip;
            $this->view->save();
        }

        return view('site.'.$module.'.single',compact('singleData', 'otherData'));
    }

    // public function post_search(Request $request)
    // {
    //     $module = $this->module;
    //     $searchText = $request->searchText;
    //     Session::put('searchText', $searchText);

    //     $allData = $this->data->where('status', 1)
    //         ->where('name', 'like', '%' .$searchText. '%')
    //         ->orWhere('description', 'like', '%' .$searchText. '%')
    //         ->orWhere('content', 'like', '%' .$searchText. '%')
    //         ->orWhere('sku', 'like', '%' .$searchText. '%')
    //         ->paginate(28);

    //     if(count($allData)>0) {
    //         return view('site.'.$module.'.index', compact('allData'));
    //     }else{
    //         return redirect()->back()->with('error', 'No data found for your search keyword: '.$searchText);
    //     }
    // }
    
    
    public function post_search(Request $request)
    {
        $searchText = $request->searchText;

        if($searchText){
            return redirect('search/p-'.$searchText);
        }else{
            return redirect('products')->with('success', 'Products Not Found!');
        }
    }

    public function get_search_product($searchText)
    {
        $module = $this->module;
        // $searchText = $request->searchText;
        Session::put('searchText', $searchText);

        // $allData = $this->data
        //  	->where('status', 1)
        //  	->whereHas('category', function($query) {
        //            $query->where('status', 1);
        //         })
        // 	->where('name', 'like', '%' .$searchText. '%')
        // 	->orWhere('description', 'like', '%' .$searchText. '%')
        // 	->orWhere('content', 'like', '%' .$searchText. '%')
        // 	->orWhere('sku', 'like', '%' .$searchText. '%')
        // 	->paginate(18);

        $allData = $this->data
            // ->where('status', 1)
            ->orWhere('title', 'like', '%' .$searchText. '%')
            ->orWhere('upc', $searchText)
            ->orWhere('product_id', $searchText)
            ->paginate(28);

        if(count($allData)>0) {
            return view('site.'.$module.'.index', compact('allData'));
        }else{
            return redirect()->back()->with('error', 'No data found for your search keyword: '.$searchText);
        }
    }
    
    
    // public function get_all_categories()
    // {   
    //     $module = $this->module;
    //     $allData = $this->category->where('status', 1)->paginate(12);
    //     return view('site.'.$module.'.categories', compact('allData'));
    // }



    public function get_all_brands()
    {   
        $module = $this->module;
        $allData = $this->productBrand->where('status', 1)->orderBY('name', 'ASC')->paginate(30);
        return view('site.'.$module.'.brands', compact('allData'));
    }




    public function products_filter()
    {
        $module = $this->module;
        $allData = $this->data->where('status', 1)->orderBy('created_at','DESC')->paginate(8);
        $categories = $this->category->where('status', 1)->orderBy('created_at','DESC')->get();
        $brands = $this->productBrand->where('status', 1)->orderBy('created_at','DESC')->get();
        return view('site.'.$module.'.product_filter', compact('allData','categories','brands'));
    }

    public function sub_categories_of_categories($subcatslug)
    {
        $module = $this->module;
        $category = $this->category->where('status', 1)->where('slug', $subcatslug)->orderBy('created_at','DESC')->first();
        $allData = $this->categorySub->where('status', 1)->where('category_id', $category->id)->paginate(30);
        return view('site.'.$module.'.sub_categories', compact('allData'));
    }

    // public function get_products_by_main_category($slug)
    // {
    //     $module = $this->module;
    //     $categoriesData = $this->category->where('status', 1)->get();

    //     $mainCategory = $this->category->where('slug', $slug)->where('status', 1)->first();
    //     if (!$mainCategory) {
    //         return view('site.errors.404');
    //     }

    //     $allData = $this->data->where('main_category_id', $mainCategory->id)->where('status', 1)->paginate(12);

    //     return view('site.'.$module.'.index', compact('allData', 'categoriesData'));
    // }

    // public function get_products_by_sub_category($slug)
    // {
    //     $module = $this->module;
    //     $categoriesData = $this->category->where('status', 1)->get();

    //     $subCategory = $this->categorySub->where('slug', $slug)->where('status', 1)->first();
    //     if (!$subCategory) {
    //         return view('site.errors.404');
    //     }
    //     $allData = $this->data->where('category_id', $subCategory->id)->where('status', 1)->paginate(12);

    //     return view('site.'.$module.'.index', compact('allData', 'categoriesData'));
    // }








    // ---
    public function get_main_categories()
    {   
        $module = $this->module;
        
        $categories = $this->category->where('status', 1)->paginate(50);
        $rsrCategories = $this->rsrCategory->where('status', 1)->groupBy('category_id')->orderBy('category_name', 'ASC')->paginate(50);

        return view('site.'.$module.'.categories', compact('categories', 'rsrCategories'));
    }

    public function get_brands()
    {
        $module = $this->module;

        $rsrManufactures = $this->rsrProduct->groupBy('manufacturer_id')->paginate(50);
        $brands = $this->productBrand->where('status', 1)->orderBY('name', 'ASC')->paginate(50);

        return view('site.'.$module.'.brands', compact('rsrManufactures', 'brands'));
    }

    // public function get_products_by_main_category($slug)
    // {
    //     $module = $this->module;

    //     $mainCategory = $this->category->where('slug', $slug)->where('status', 1)->first();
    //     $rsrMainCategory = $this->rsrCategory->where('status', 1)->where('department_id', $slug)->first();

    //     $allData = collect([]);
    //     $rsrProductsData = collect([]);

    //     if (!$mainCategory && !$rsrMainCategory) {
    //         return view('site.errors.404');
    //     }

    //     if ($mainCategory) {
    //         $allData = $this->data->where('main_category_id', $mainCategory->id)->where('status', 1)->paginate(28);
    //     }

    //     if ($rsrMainCategory) {
    //         $rsrProductsData = $this->rsrProduct->where('department_number', $slug)->paginate(28);
    //     }

    //     return view('site.'.$module.'.index_categories', compact('allData', 'rsrProductsData'));
    // }

    public function get_products_by_main_category($slug)
    {
        $module = $this->module;

        $allData = collect([]);
        $rsrProductsData = collect([]);
        $rsrMainCategory = collect([]);

        $rsrCalibersByMainCategory = collect([]);
        $rsrBarrelLengthsByMainCategory = collect([]);
        $rsrColorsByMainCategory = collect([]);
        $rsrManufacturerByMainCategory = collect([]);
        $rsrActionsByMainCategory = collect([]);
        $rsrfinishesByMainCategory = collect([]);
        $rsrGripsByMainCategory = collect([]);
        $rsrHandsByMainCategory = collect([]);
        $rsrTypesByMainCategory = collect([]);
        $rsrTypesByMainCategory = collect([]);
        $rsrWtCharacteristicsByMainCategory = collect([]);
        $rsrSubCategoryByMainCategory = collect([]);
        $rsrOunceOfShotByMainCategory = collect([]);
        $rsrGrainWeightByMainCategory = collect([]);
        $rsrDramByMainCategory = collect([]);
        $rsrCaCertifiedNonleadByMainCategory = collect([]);

        $mainCategory = $this->category->where('slug', $slug)->where('status', 1)->first();
        $rsrMainCategory = $this->rsrCategory->where('status', 1)->where('department_id', $slug)->first();

        if (!$mainCategory && !$rsrMainCategory) {
            return view('site.errors.404');
        }

        if ($mainCategory) {
            $allData = $this->data->where('main_category_id', $mainCategory->id)->where('status', 1)->paginate(28);
        }

        if ($rsrMainCategory) {
            $productIds = $this->rsrProduct->where('department_number', $slug)->pluck('rsr_stock_number')->toArray();

            // Caliber
            $rsrCalibersByMainCategory = RsrProducAttribute::whereNotNull('caliber')->whereIn('rsr_stock_number', $productIds)->groupBY('caliber')->orderBy('caliber', 'ASC')->get(['caliber']);
            // Barrel
            $rsrBarrelLengthsByMainCategory = RsrProducAttribute::whereNotNull('barrel_length')->whereIn('rsr_stock_number', $productIds)->groupBy('barrel_length')->orderBy('barrel_length', 'ASC')->get(['barrel_length']);
            // Color
            $rsrColorsByMainCategory = RsrProducAttribute::whereNotNull('color')->whereIn('rsr_stock_number', $productIds)->groupBy('color')->orderBy('color', 'ASC')->get(['color']);
            // Manufacturer
            $rsrManufacturerByMainCategory = RsrProducAttribute::whereNotNull('manufacturer_id')->whereIn('rsr_stock_number', $productIds)->groupBy('manufacturer_id')->orderBy('manufacturer_id', 'ASC')->get(['manufacturer_id']);
            // Action
            $rsrActionsByMainCategory = RsrProducAttribute::whereNotNull('action')->whereIn('rsr_stock_number', $productIds)->groupBy('action')->orderBy('action', 'ASC')->get(['action']);
            // Finish
            $rsrfinishesByMainCategory = RsrProducAttribute::whereNotNull('finish')->whereIn('rsr_stock_number', $productIds)->groupBy('finish')->orderBy('finish', 'ASC')->get(['finish']);
            // Grips
            $rsrGripsByMainCategory = RsrProducAttribute::whereNotNull('grips')->whereIn('rsr_stock_number', $productIds)->groupBy('grips')->orderBy('grips', 'ASC')->get(['grips']);
            // Hand
            $rsrHandsByMainCategory = RsrProducAttribute::whereNotNull('hand')->whereIn('rsr_stock_number', $productIds)->groupBy('hand')->orderBy('hand', 'ASC')->get(['hand']);
            // Type
            $rsrTypesByMainCategory = RsrProducAttribute::whereNotNull('type')->whereIn('rsr_stock_number', $productIds)->groupBy('type')->orderBy('type', 'ASC')->get(['type']);
            // WT Characteristics
            $rsrWtCharacteristicsByMainCategory = RsrProducAttribute::whereNotNull('wt_characteristics')->whereIn('rsr_stock_number', $productIds)->groupBy('wt_characteristics')->orderBy('wt_characteristics', 'ASC')->get(['wt_characteristics']);
            // Subcategory
            $rsrSubCategoryByMainCategory = RsrProducAttribute::whereNotNull('sub_category')->whereIn('rsr_stock_number', $productIds)->groupBy('sub_category')->orderBy('sub_category', 'ASC')->get(['sub_category']);
            // Ounce of shot
            $rsrOunceOfShotByMainCategory = RsrProducAttribute::whereNotNull('ounce_of_shot')->whereIn('rsr_stock_number', $productIds)->groupBy('ounce_of_shot')->orderBy('ounce_of_shot', 'ASC')->get(['ounce_of_shot']);
            // Grain weight
            $rsrGrainWeightByMainCategory = RsrProducAttribute::whereNotNull('grain_weight')->whereIn('rsr_stock_number', $productIds)->groupBy('grain_weight')->orderBy('grain_weight', 'ASC')->get(['grain_weight']);
            // dram
            $rsrDramByMainCategory = RsrProducAttribute::whereNotNull('dram')->whereIn('rsr_stock_number', $productIds)->groupBy('dram')->orderBy('dram', 'ASC')->get(['dram']);
            // ca certified nonlead

            $from_price = (int)request()->from_price;
            $to_price = (int)request()->to_price;

            $allDataBuilder = RsrProduct::query();

            request()->category_ids ? $allDataBuilder->whereIn('department_number', request()->category_ids)->get() : null;

            request()->stock_availability ? $allDataBuilder->where('inventory_quantity', '>', request()->stock_availability)->get() : null;

            // ---
            if ($from_price && $to_price) {
                 $allDataBuilder->where('retail_price', '>=', $from_price)
                    ->where('retail_price', '<=', $to_price)
                    ->get();
            }elseif($from_price){
                $allDataBuilder->where('retail_price', $from_price)->get();
            }elseif($to_price){
                $allDataBuilder->where('retail_price', $to_price)->get();
            }

            // ---
            $retailPrice = "CAST(retail_price AS DECIMAL(10,2)) ASC";
            if (request()->sort_by == "low_to_high") {
                $allDataBuilder->orderByRaw($retailPrice, 'ASC')->get();
            }elseif(request()->sort_by == "high_to_low"){
                $allDataBuilder->orderByRaw("CAST(retail_price AS DECIMAL(10,2)) DESC")->get();
                // $allDataBuilder->orderBy('retail_price', 'desc')->get();
            }elseif(request()->sort_by == "available_quantity"){
                $allDataBuilder->orderByRaw("CAST(inventory_quantity AS DECIMAL(10)) DESC")->where('inventory_quantity', '>', 0)->get();
                // $allDataBuilder->orderBy('inventory_quantity', 'ASC')->get();
            }else{
                $allDataBuilder->orderBy('product_description', 'ASC')->get();
            }

            if (request()->calibers) {
                $calibersArray = $this->rsrProducAttribute->whereIn('caliber', request()->calibers)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $calibersArray)->get();
            }

            if (request()->barrel_lengths) {
                $barrelLengthsArray = $this->rsrProducAttribute->whereIn('barrel_length', request()->barrel_lengths)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $barrelLengthsArray)->get();
            }

            if (request()->colors) {
                $colorsArray = $this->rsrProducAttribute->whereIn('color', request()->colors)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $colorsArray)->get();
            }

            if (request()->manufacturers) {
                $allDataBuilder->whereIn('manufacturer_id', request()->manufacturers)->get();
            }

            if (request()->actions) {
                $actionsArray = $this->rsrProducAttribute->whereIn('action', request()->actions)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $actionsArray)->get();
            }

            if (request()->finishes) {
                $finishesArray = $this->rsrProducAttribute->whereIn('finish', request()->finishes)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $finishesArray)->get();
            }

            if (request()->grips) {
                $gripsArray = $this->rsrProducAttribute->whereIn('grips', request()->grips)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $gripsArray)->get();
            }

            if (request()->hands) {
                $gripsArray = $this->rsrProducAttribute->whereIn('hand', request()->hands)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $gripsArray)->get();
            }

            if (request()->types) {
                $typesArray = $this->rsrProducAttribute->whereIn('type', request()->types)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $typesArray)->get();
            }

            if (request()->wt_characteristics) {
                $wtCharacteristicsArray = $this->rsrProducAttribute->whereIn('wt_characteristics', request()->wt_characteristics)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $wtCharacteristicsArray)->get();
            }

            if (request()->subcategories) {
                $subcategoriesArray = $this->rsrProducAttribute->whereIn('sub_category', request()->subcategories)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $subcategoriesArray)->get();
            }

            if (request()->ounce_of_shots) {
                $subcategoriesArray = $this->rsrProducAttribute->whereIn('ounce_of_shot', request()->ounce_of_shots)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $subcategoriesArray)->get();
            }

            if (request()->grain_weights) {
                $subcategoriesArray = $this->rsrProducAttribute->whereIn('grain_weight', request()->grain_weights)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $subcategoriesArray)->get();
            }

            if (request()->drams) {
                $subcategoriesArray = $this->rsrProducAttribute->whereIn('dram', request()->drams)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $subcategoriesArray)->get();
            }

            $rsrProductsData = $allDataBuilder->where('department_number', $slug)->paginate(request()->products_per_page?? 24)->appends([
                'category_ids' => request()->category_ids,
                'stock_availability' => request()->stock_availability,
                'from_price' => request()->from_price,
                'to_price' => request()->to_price,
                'products_per_page' => request()->products_per_page,
                'sort_by' => request()->sort_by,
                'calibers' => request()->calibers,
                'barrel_lengths' => request()->barrel_lengths,
                'colors' => request()->colors,
                'manufacturers' => request()->manufacturers,
                'actions' => request()->actions,
                'finishes' => request()->finishes,
                'grips' => request()->grips,
                'hands' => request()->hands,
                'types' => request()->types,
                'wt_characteristics' => request()->wt_characteristics,
                'subcategories' => request()->subcategories,
                'ounce_of_shots' => request()->ounce_of_shots,
                'grain_weights' => request()->grain_weights,
                'drams' => request()->drams,
            ]);
            // $rsrProductsData = $this->rsrProduct->where('department_number', $slug)->paginate(28);
        }

        // return view('site.'.$module.'.index_categories', compact('allData', 'rsrProductsData'));

        return view('site.'.$module.'.index_main_category', compact('rsrMainCategory', 'allData', 'rsrProductsData', 'rsrCalibersByMainCategory', 'rsrBarrelLengthsByMainCategory', 'rsrManufacturerByMainCategory', 'rsrColorsByMainCategory', 'rsrActionsByMainCategory', 'rsrfinishesByMainCategory', 'rsrGripsByMainCategory', 'rsrHandsByMainCategory', 'rsrTypesByMainCategory', 'rsrWtCharacteristicsByMainCategory', 'rsrSubCategoryByMainCategory', 'rsrOunceOfShotByMainCategory', 'rsrGrainWeightByMainCategory', 'rsrDramByMainCategory'));
    }

    public function get_products_by_sub_category($slug)
    {
        // dump(request()->path());
        // dump(request()->all());

        $module = $this->module;

        $subCategory = $this->categorySub->where('slug', $slug)->where('status', 1)->first();
        $rsrSubCategory = $this->rsrSubCategory->where('status', 1)->where('value', $slug)->first();

        $allData = collect([]);
        $rsrProductsData = collect([]);

        $rsrCalibersBySubCategory = collect([]);
        $rsrBarrelLengthsBySubCategory = collect([]);
        $rsrColorsBySubCategory = collect([]);
        $rsrActionsBySubCategory = collect([]);
        $rsrManufacturerBySubCategory = collect([]);
        $rsrActionsBySubCategory = collect([]);
        $rsrfinishesBySubCategory = collect([]);
        $rsrGripsBySubCategory = collect([]);
        $rsrHandsBySubCategory = collect([]);
        $rsrTypesBySubCategory = collect([]);
        $rsrWtCharacteristicsBySubCategory = collect([]);

        if (!$subCategory && !$rsrSubCategory) {
            return view('site.errors.404');
        }

        if ($subCategory) {
            $allData = $this->data->where('sub_category_id', $subCategory->id)->where('status', 1)->paginate(28);
        }

        if ($rsrSubCategory) {
            // $rsrProductsIds = $this->rsrSubCategory->where('value', $slug)->pluck('rsr_stock_number')->toArray(); 
            // $rsrProductsData = $this->rsrProduct->whereIn('rsr_stock_number', $rsrProductsIds)->paginate(28);

            // Caliber
            $rsrCalibersBySubCategory = RsrProducAttribute::whereNotNull('caliber')->where('sub_category', $slug)->groupBY('caliber')->orderBy('caliber', 'ASC')->get(['caliber']);

            // Barrel
            $rsrBarrelLengthsBySubCategory = RsrProducAttribute::whereNotNull('barrel_length')->where('sub_category', $slug)->groupBy('barrel_length')->orderBy('barrel_length', 'ASC')->get(['barrel_length']);

            // Color
            $rsrColorsBySubCategory = RsrProducAttribute::whereNotNull('color')->where('sub_category', $slug)->groupBy('color')->orderBy('color', 'ASC')->get(['color']);

            // Manufacturer
            $rsrManufacturerBySubCategory = RsrProducAttribute::whereNotNull('manufacturer_id')->where('sub_category', $slug)->groupBy('manufacturer_id')->orderBy('manufacturer_id', 'ASC')->get(['manufacturer_id']);

            // Action
            $rsrActionsBySubCategory = RsrProducAttribute::whereNotNull('action')->where('sub_category', $slug)->groupBy('action')->orderBy('action', 'ASC')->get(['action']);

            // Finish
            $rsrfinishesBySubCategory = RsrProducAttribute::whereNotNull('finish')->where('sub_category', $slug)->groupBy('finish')->orderBy('finish', 'ASC')->get(['finish']);

            // Grips
            $rsrGripsBySubCategory = RsrProducAttribute::whereNotNull('grips')->where('sub_category', $slug)->groupBy('grips')->orderBy('grips', 'ASC')->get(['grips']);

            // Hand
            $rsrHandsBySubCategory = RsrProducAttribute::whereNotNull('hand')->where('sub_category', $slug)->groupBy('hand')->orderBy('hand', 'ASC')->get(['hand']);

            // Type
            $rsrTypesBySubCategory = RsrProducAttribute::whereNotNull('type')->where('sub_category', $slug)->groupBy('type')->orderBy('type', 'ASC')->get(['type']);

            // WT Characteristics
            $rsrWtCharacteristicsBySubCategory = RsrProducAttribute::whereNotNull('wt_characteristics')->where('sub_category', $slug)->groupBy('wt_characteristics')->orderBy('wt_characteristics', 'ASC')->get(['wt_characteristics']);

            $from_price = (int)request()->from_price;
            $to_price = (int)request()->to_price;

            $allDataBuilder = RsrProduct::query();

            request()->category_ids ? $allDataBuilder->whereIn('department_number', request()->category_ids)->get() : null;

            request()->stock_availability ? $allDataBuilder->where('inventory_quantity', '>', request()->stock_availability)->get() : null;

            if ($from_price && $to_price) {
                 $allDataBuilder->where('retail_price', '>=', $from_price)
                    ->where('retail_price', '<=', $to_price)
                    ->get();
            }elseif($from_price){
                $allDataBuilder->where('retail_price', $from_price)->get();
            }elseif($to_price){
                $allDataBuilder->where('retail_price', $to_price)->get();
            }

            $retailPrice = "CAST(retail_price AS DECIMAL(10,2)) ASC";

            if (request()->sort_by == "low_to_high") {
                $allDataBuilder->orderByRaw($retailPrice, 'ASC')->get();
            }elseif(request()->sort_by == "high_to_low"){
                $allDataBuilder->orderByRaw("CAST(retail_price AS DECIMAL(10,2)) DESC")->get();
                // $allDataBuilder->orderBy('retail_price', 'desc')->get();
            }elseif(request()->sort_by == "available_quantity"){
                $allDataBuilder->orderByRaw("CAST(inventory_quantity AS DECIMAL(10)) DESC")->where('inventory_quantity', '>', 0)->get();
                // $allDataBuilder->orderBy('inventory_quantity', 'ASC')->get();
            }else{
                $allDataBuilder->orderBy('product_description', 'ASC')->get();
            }

            if (request()->calibers) {
                $calibersArray = $this->rsrProducAttribute->whereIn('caliber', request()->calibers)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $calibersArray)->get();
            }

            if (request()->barrel_lengths) {
                $barrelLengthsArray = $this->rsrProducAttribute->whereIn('barrel_length', request()->barrel_lengths)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $barrelLengthsArray)->get();
            }

            if (request()->colors) {
                $colorsArray = $this->rsrProducAttribute->whereIn('color', request()->colors)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $colorsArray)->get();
            }

            if (request()->manufacturers) {
                $allDataBuilder->whereIn('manufacturer_id', request()->manufacturers)->get();
            }

            if (request()->actions) {
                $actionsArray = $this->rsrProducAttribute->whereIn('action', request()->actions)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $actionsArray)->get();
            }

            if (request()->finishes) {
                $finishesArray = $this->rsrProducAttribute->whereIn('finish', request()->finishes)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $finishesArray)->get();
            }

            if (request()->grips) {
                $gripsArray = $this->rsrProducAttribute->whereIn('grips', request()->grips)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $gripsArray)->get();
            }

            if (request()->hands) {
                $gripsArray = $this->rsrProducAttribute->whereIn('hand', request()->hands)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $gripsArray)->get();
            }

            if (request()->types) {
                $typesArray = $this->rsrProducAttribute->whereIn('type', request()->types)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $typesArray)->get();
            }

            if (request()->wt_characteristics) {
                $wtCharacteristicsArray = $this->rsrProducAttribute->whereIn('wt_characteristics', request()->wt_characteristics)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $wtCharacteristicsArray)->get();
            }

            $rsrProductsIds = $this->rsrSubCategory->where('value', $slug)->pluck('rsr_stock_number')->toArray(); 
            $rsrProductsData = $allDataBuilder->whereIn('rsr_stock_number', $rsrProductsIds)->paginate(request()->products_per_page?? 12)->appends([
                'category_ids' => request()->category_ids,
                'stock_availability' => request()->stock_availability,
                'from_price' => request()->from_price,
                'to_price' => request()->to_price,
                'products_per_page' => request()->products_per_page,
                'sort_by' => request()->sort_by,
                'calibers' => request()->calibers,
                'barrel_lengths' => request()->barrel_lengths,
                'colors' => request()->colors,
                'manufacturers' => request()->manufacturers,
                'actions' => request()->actions,
                'finishes' => request()->finishes,
                'grips' => request()->grips,
                'hands' => request()->hands,
                'types' => request()->types,
                'wt_characteristics' => request()->wt_characteristics,
            ]);
        }

        return view('site.'.$module.'.index_sub_category', compact('allData', 'rsrProductsData', 'rsrCalibersBySubCategory', 'rsrBarrelLengthsBySubCategory', 'rsrManufacturerBySubCategory', 'rsrColorsBySubCategory', 'rsrActionsBySubCategory', 'rsrfinishesBySubCategory', 'rsrGripsBySubCategory', 'rsrHandsBySubCategory', 'rsrTypesBySubCategory', 'rsrWtCharacteristicsBySubCategory'));
    }

    public function get_products_by_brand($slug)
    {
        $module = $this->module;

        $brand = $this->productBrand->where('status', 1)->where('slug', $slug)->first();
        $rsrManufacture = $this->rsrProduct->where('manufacturer_id', $slug)->first();

        $allData = collect([]);
        $rsrProductsData = collect([]);

        if (!$brand && !$rsrManufacture) {
            return view('site.errors.404');
        }

        if ($brand) {
            $allData = $this->data->where('status', 1)->where('brand_id', $brand->id)->paginate(24);
        }

        if ($rsrManufacture) {
            $rsrProductsData = $this->rsrProduct->where('manufacturer_id', $slug)->paginate(24);
        }

        return view('site.'.$module.'.index_brands', compact('allData', 'rsrProductsData'));
    }

    // public function get_manufacturers()
    // {
    //     $module = $this->module;

    //     $manufacturers = $this->productBrand->where('status', 1)->orderBY('name', 'ASC')->paginate(50);
    //     $rsrManufactures = $this->rsrProduct->groupBy('manufacturer_id')->paginate(50);

    //     return view('site.'.$module.'.brands', compact('rsrManufactures', 'manufacturers'));
    // }

    public function get_products_by_manufacturer($slug)
    {
        $module = $this->module;

        $brand = $this->productBrand->where('status', 1)->where('slug', $slug)->first();
        $rsrManufacture = $this->rsrProduct->where('manufacturer_id', $slug)->first();

        $allData = collect([]);
        $rsrProductsData = collect([]);

        $rsrCalibersByManufacturer = collect([]);
        $rsrBarrelLengthsByManufacturer = collect([]);
        $rsrColorsByManufacturer = collect([]);
        $rsrManufacturerByManufacturer = collect([]);
        $rsrActionsByManufacturer = collect([]);
        $rsrfinishesByManufacturer = collect([]);
        $rsrGripsByManufacturer = collect([]);
        $rsrHandsByManufacturer = collect([]);
        $rsrTypesByManufacturer = collect([]);
        $rsrTypesByManufacturer = collect([]);
        $rsrWtCharacteristicsByManufacturer = collect([]);
        $rsrSubCategoryByManufacturer = collect([]);
        $rsrOunceOfShotByManufacturer = collect([]);
        $rsrGrainWeightByManufacturer = collect([]);
        $rsrDramByManufacturer = collect([]);
        $rsrCaCertifiedNonleadByManufacturer = collect([]);

        if (!$brand && !$rsrManufacture) {
            return view('site.errors.404');
        }

        if ($brand) {
            $allData = $this->data->where('status', 1)->where('brand_id', $brand->id)->paginate(28);
        }

        if ($rsrManufacture) {
            $productIds = $this->rsrProduct->where('department_number', $slug)->pluck('rsr_stock_number')->toArray();

            // Caliber
            $rsrCalibersByMainCategory = RsrProducAttribute::whereNotNull('caliber')->whereIn('rsr_stock_number', $productIds)->groupBY('caliber')->orderBy('caliber', 'ASC')->get(['caliber']);
            // Barrel
            $rsrBarrelLengthsByMainCategory = RsrProducAttribute::whereNotNull('barrel_length')->whereIn('rsr_stock_number', $productIds)->groupBy('barrel_length')->orderBy('barrel_length', 'ASC')->get(['barrel_length']);
            // Color
            $rsrColorsByMainCategory = RsrProducAttribute::whereNotNull('color')->whereIn('rsr_stock_number', $productIds)->groupBy('color')->orderBy('color', 'ASC')->get(['color']);
            // Manufacturer
            $rsrManufacturerByMainCategory = RsrProducAttribute::whereNotNull('manufacturer_id')->whereIn('rsr_stock_number', $productIds)->groupBy('manufacturer_id')->orderBy('manufacturer_id', 'ASC')->get(['manufacturer_id']);
            // Action
            $rsrActionsByMainCategory = RsrProducAttribute::whereNotNull('action')->whereIn('rsr_stock_number', $productIds)->groupBy('action')->orderBy('action', 'ASC')->get(['action']);
            // Finish
            $rsrfinishesByMainCategory = RsrProducAttribute::whereNotNull('finish')->whereIn('rsr_stock_number', $productIds)->groupBy('finish')->orderBy('finish', 'ASC')->get(['finish']);
            // Grips
            $rsrGripsByMainCategory = RsrProducAttribute::whereNotNull('grips')->whereIn('rsr_stock_number', $productIds)->groupBy('grips')->orderBy('grips', 'ASC')->get(['grips']);
            // Hand
            $rsrHandsByMainCategory = RsrProducAttribute::whereNotNull('hand')->whereIn('rsr_stock_number', $productIds)->groupBy('hand')->orderBy('hand', 'ASC')->get(['hand']);
            // Type
            $rsrTypesByMainCategory = RsrProducAttribute::whereNotNull('type')->whereIn('rsr_stock_number', $productIds)->groupBy('type')->orderBy('type', 'ASC')->get(['type']);
            // WT Characteristics
            $rsrWtCharacteristicsByMainCategory = RsrProducAttribute::whereNotNull('wt_characteristics')->whereIn('rsr_stock_number', $productIds)->groupBy('wt_characteristics')->orderBy('wt_characteristics', 'ASC')->get(['wt_characteristics']);
            // Subcategory
            $rsrSubCategoryByMainCategory = RsrProducAttribute::whereNotNull('sub_category')->whereIn('rsr_stock_number', $productIds)->groupBy('sub_category')->orderBy('sub_category', 'ASC')->get(['sub_category']);
            // Ounce of shot
            $rsrOunceOfShotByMainCategory = RsrProducAttribute::whereNotNull('ounce_of_shot')->whereIn('rsr_stock_number', $productIds)->groupBy('ounce_of_shot')->orderBy('ounce_of_shot', 'ASC')->get(['ounce_of_shot']);
            // Grain weight
            $rsrGrainWeightByMainCategory = RsrProducAttribute::whereNotNull('grain_weight')->whereIn('rsr_stock_number', $productIds)->groupBy('grain_weight')->orderBy('grain_weight', 'ASC')->get(['grain_weight']);
            // dram
            $rsrDramMainCategory = RsrProducAttribute::whereNotNull('dram')->whereIn('rsr_stock_number', $productIds)->groupBy('dram')->orderBy('dram', 'ASC')->get(['dram']);
            // ca certified nonlead

            $from_price = (int)request()->from_price;
            $to_price = (int)request()->to_price;

            $allDataBuilder = RsrProduct::query();

            request()->category_ids ? $allDataBuilder->whereIn('department_number', request()->category_ids)->get() : null;

            request()->stock_availability ? $allDataBuilder->where('inventory_quantity', '>', request()->stock_availability)->get() : null;

            if ($from_price && $to_price) {
                 $allDataBuilder->where('retail_price', '>=', $from_price)
                    ->where('retail_price', '<=', $to_price)
                    ->get();
            }elseif($from_price){
                $allDataBuilder->where('retail_price', $from_price)->get();
            }elseif($to_price){
                $allDataBuilder->where('retail_price', $to_price)->get();
            }

            $retailPrice = "CAST(retail_price AS DECIMAL(10,2)) ASC";

            if (request()->sort_by == "low_to_high") {
                $allDataBuilder->orderByRaw($retailPrice, 'ASC')->get();
            }elseif(request()->sort_by == "high_to_low"){
                $allDataBuilder->orderByRaw("CAST(retail_price AS DECIMAL(10,2)) DESC")->get();
                // $allDataBuilder->orderBy('retail_price', 'desc')->get();
            }elseif(request()->sort_by == "available_quantity"){
                $allDataBuilder->orderByRaw("CAST(inventory_quantity AS DECIMAL(10)) DESC")->where('inventory_quantity', '>', 0)->get();
                // $allDataBuilder->orderBy('inventory_quantity', 'ASC')->get();
            }else{
                $allDataBuilder->orderBy('product_description', 'ASC')->get();
            }

            if (request()->calibers) {
                $calibersArray = $this->rsrProducAttribute->whereIn('caliber', request()->calibers)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $calibersArray)->get();
            }

            if (request()->barrel_lengths) {
                $barrelLengthsArray = $this->rsrProducAttribute->whereIn('barrel_length', request()->barrel_lengths)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $barrelLengthsArray)->get();
            }

            if (request()->colors) {
                $colorsArray = $this->rsrProducAttribute->whereIn('color', request()->colors)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $colorsArray)->get();
            }

            if (request()->manufacturers) {
                $allDataBuilder->whereIn('manufacturer_id', request()->manufacturers)->get();
            }

            if (request()->actions) {
                $actionsArray = $this->rsrProducAttribute->whereIn('action', request()->actions)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $actionsArray)->get();
            }

            if (request()->finishes) {
                $finishesArray = $this->rsrProducAttribute->whereIn('finish', request()->finishes)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $finishesArray)->get();
            }

            if (request()->grips) {
                $gripsArray = $this->rsrProducAttribute->whereIn('grips', request()->grips)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $gripsArray)->get();
            }

            if (request()->hands) {
                $gripsArray = $this->rsrProducAttribute->whereIn('hand', request()->hands)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $gripsArray)->get();
            }

            if (request()->types) {
                $typesArray = $this->rsrProducAttribute->whereIn('type', request()->types)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $typesArray)->get();
            }

            if (request()->wt_characteristics) {
                $wtCharacteristicsArray = $this->rsrProducAttribute->whereIn('wt_characteristics', request()->wt_characteristics)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $wtCharacteristicsArray)->get();
            }

            if (request()->subcategories) {
                $subcategoriesArray = $this->rsrProducAttribute->whereIn('sub_category', request()->subcategories)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $subcategoriesArray)->get();
            }

            if (request()->ounce_of_shots) {
                $subcategoriesArray = $this->rsrProducAttribute->whereIn('ounce_of_shot', request()->ounce_of_shots)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $subcategoriesArray)->get();
            }

            if (request()->grain_weights) {
                $subcategoriesArray = $this->rsrProducAttribute->whereIn('grain_weight', request()->grain_weights)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $subcategoriesArray)->get();
            }

            if (request()->drams) {
                $subcategoriesArray = $this->rsrProducAttribute->whereIn('dram', request()->drams)->pluck('rsr_stock_number')->toArray();
                $allDataBuilder->whereIn('rsr_stock_number', $subcategoriesArray)->get();
            }

            $rsrProductsData = $allDataBuilder->where('department_number', $slug)->paginate(request()->products_per_page?? 12)->appends([
                'category_ids' => request()->category_ids,
                'stock_availability' => request()->stock_availability,
                'from_price' => request()->from_price,
                'to_price' => request()->to_price,
                'products_per_page' => request()->products_per_page,
                'sort_by' => request()->sort_by,
                'calibers' => request()->calibers,
                'barrel_lengths' => request()->barrel_lengths,
                'colors' => request()->colors,
                'manufacturers' => request()->manufacturers,
                'actions' => request()->actions,
                'finishes' => request()->finishes,
                'grips' => request()->grips,
                'hands' => request()->hands,
                'types' => request()->types,
                'wt_characteristics' => request()->wt_characteristics,
                'subcategories' => request()->subcategories,
                'ounce_of_shots' => request()->ounce_of_shots,
                'grain_weights' => request()->grain_weights,
                'drams' => request()->drams,
            ]);
            // $rsrProductsData = $this->rsrProduct->where('manufacturer_id', $slug)->paginate(28);
        }

        return view('site.'.$module.'.index_main_manufacturers', compact('allData', 'rsrProductsData', 'rsrCalibersByMainCategory', 'rsrBarrelLengthsByMainCategory', 'rsrManufacturerByMainCategory', 'rsrColorsByMainCategory', 'rsrActionsByMainCategory', 'rsrfinishesByMainCategory', 'rsrGripsByMainCategory', 'rsrHandsByMainCategory', 'rsrTypesByMainCategory', 'rsrWtCharacteristicsByMainCategory', 'rsrSubCategoryByMainCategory', 'rsrOunceOfShotByMainCategory', 'rsrGrainWeightByMainCategory', 'rsrDramByManufacturer'));
    }

    public function get_ajax_products()
    {
        $allData = $this->data
            ->where('status', 1)
            ->whereHas('rel_main_category', function($query) {
               $query->where('status', 1);
            })
            ->where('title', 'like', '%' .request()->q. '%')
            ->OrWhere('short_description', 'like', '%' .request()->q. '%')
            ->OrWhere('content', 'like', '%' .request()->q. '%')
            ->orderBy('title','ASC')
            ->paginate(28);

        return response()->json($allData);
    }

    public function searched_products(Request $request)
    {
        $request->validate([
            'q' => 'required',
        ], [
            'q.required' => 'Product name is required!',
        ]);

        $result = $this->search_products($request['q']);
        $products = $result['products'];

        return response()->json([
            'result' => view('site.partials.ajax_search', compact('products'))->render(),
        ]);
    }

    public static function search_products($name, $limit = 30, $offset = 1)
    {
        $key = explode(' ', $name);
        $paginator = RsrProduct::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('rsr_stock_number', 'like', "%{$value}%");
                $q->orWhere('upc_code', 'like', "%{$value}%");
                $q->orWhere('product_description', 'like', "%{$value}%");
                $q->orWhere('full_manufacturer_name', 'like', "%{$value}%");
                $q->orWhere('model', 'like', "%{$value}%");
                $q->orWhere('manufacturer_part_number', 'like', "%{$value}%");
                $q->orWhere('expanded_product_description', 'like', "%{$value}%");
            }
        })->paginate($limit, ['*'], 'page', $offset);

        return [
            'total_size' => $paginator->total(),
            'limit' => (integer)$limit,
            'offset' => (integer)$offset,
            'products' => $paginator->items()
        ];
    }
}