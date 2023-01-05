<?php namespace App\Http\Controllers\Site;

use App\Block;
use App\DisplayProduct;
use App\Http\Controllers\Controller;
use App\Option;
use App\OurServices;
use App\Product;
use App\ProductBrand;
use App\ProductCategory;
use App\ProductModel;
use App\RsrMainCategory;
use App\RsrProduct;
use App\Slider;
use App\SliderImage;
use Auth;
use DB;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{
    public function __construct(Slider $slider, SliderImage $image, Block $block, ProductBrand $brand, ProductModel $model, Product $product, OurServices $ourServices, ProductCategory $category,DisplayProduct $displayProduct)
    {
        $this->slider = $slider;
        $this->image = $image;
        $this->block = $block;
        $this->brand = $brand;
        $this->model = $model;
        $this->product = $product;
        $this->ourServices = $ourServices;
        $this->category = $category;
        $this->displayProduct = $displayProduct;
        $this->middleware('guest');
    }

    public function index()
    {
        if (Cache::has('optionCache')){
            $option = Cache::get('optionCache');
        }else{
            $option = Option::first();
            Cache::forever('optionCache', $option);
        }
        
        // if (Cache::has('themeCache')){
        //     $siteThemeSettings = Cache::get('themeCache');
        // }else{
        //     $siteThemeSettings = ThemeSettings::first();
        //     Cache::forever('themeCache', $siteThemeSettings);
        // }

        if($option->status == 1 || Auth::id()) {
            $slider = $this->slider->where('status', 1)->first();

            if($slider){
                $sliderImage = $this->image->where('slider_id', $slider->id)->orderBy('order', 'ASC')->get();

                // $sliderImage = cache()->remember('sliderImageCache', 60*60*24, function() use ($slider){
                //             return $this->image->where('slider_id', $slider->id)->orderBy('order', 'ASC')->get();
                //         });
            }

            // $offerBox = $this->block->where('slug', 'offer-box')->where('status', 1)->first();
            // $limitedOffer = $this->block->where('slug', 'limited-time-offer')->where('status', 1)->first();
            // $staffsPicks = $this->block->where('slug', 'staffs-picks')->where('status', 1)->first();
            // $sectionIntroBox = $this->block->where('slug', 'intro-box-below-slider')->where('status', 1)->first();
            // $services = $this->block->where('slug', 'services')->where('status', 1)->first();
            // $sliderBottom = $this->block->where('slug', 'below-slider')->where('status', 1)->first();

            $brandsData = $this->brand->where('status',1)->orderBy('updated_at', 'DESC')->get();
            // $featuredProducts = $this->product
            // 	->where('status',1)
            // 	->whereHas('category', function($query) {
            //        $query->where('status', 1);
            //     })
            // 	->where('is_featured', 1)
            // 	->get();
            // $sectionInfoData = $this->sectionInfo->first();
            // $sectionOfferData = $this->sectionOffer->first();

            
            // $newArrivals = $this->product->where('status',1)->orderBy('created_at', 'DESC')->take(3)->get();
            // $newArrivalsCarosol = $this->product->where('status',1)->orderBy('updated_at', 'DESC')->take(20)->get();
            // $topViewed = $this->product->where('status',1)->withCount('views')->orderBy('views_count', 'DESC')->take(3)->get();
            // $bestSales = $this->product->where('status',1)->withCount('sales')->orderBy('sales_count', 'DESC')->take(3)->get();
            
            // $ourServicesData = $this->ourServices->where('status',1)->get();
            // $sectionProductData = $this->sectionProduct->first();

            // Home Page Data
   //          $limitedTimeOfferData = $this->product
   //          	->where('status',1)
   //          	->whereHas('category', function($query) {
			// $query->where('status', 1);
   //              })
   //          	->whereDate('offer_ended_at', '>=', date('Y-m-d'))
   //          	->limit(12)
   //          	->get();

   //          $newProductsData = $this->product
   //          	->where('status',1)
   //          	->whereHas('category', function($query) {
			// $query->where('status', 1);
   //              })
   //          	->orderBy('updated_at', 'DESC')
   //          	->groupBy('parent_product_id')
   //          	->limit(20)
   //          	->get();

            $categoriesData = $this->category->where('status', 1)->orderBy('updated_at', 'DESC')->limit(12)->get();
            $rsrMaincategoriesData = RsrMainCategory::where('status', 1)->groupBy('category_id')->orderBy('category_name', 'ASC')->get();

            // AD Data
            // $UnderFearuredItems = $this->advertisement->where('display', "UnderFeaturedItems")->where('status', 1)->first();
            // $UnderNewProducts = $this->advertisement->where('display', "UnderNewProducts")->where('status', 1)->first();
            // $UnderTopCategories = $this->advertisement->where('display', "UnderTopCategories")->where('status', 1)->first();
            // $UnderSpecialOffers = $this->advertisement->where('display', "UnderSpecialOffers")->where('status', 1)->first();

            // Last 50 products
            // $lastFiftyProducts = $this->product->orderBy('created_at', 'DESC')->take(50)->pluck('id')->toArray();
            // $testimonialData = $this->testimonial->where('status', 1)->get();

            // Blog Data
            // $blogsData = $this->blog->whereStatus(1)->orderBy('updated_at', 'DESC')->get();

            // Company
            // $companyData = $this->company->whereStatus(1)->get();

            // 
            // $productIdsByStore = $this->storeProduct->where('store_id', 0)->pluck('product_id')->toArray();

            // Featured Products
            $featuredProductIds = $this->displayProduct->where('type', 1)->where('store_type', 0)->orderBy('created_at', 'DESC')->pluck('product_id')->toArray();
            // $matchedFeaturedProductIds = array_intersect($productIdsByStore,  $featuredProductIds);
            $featuredProductsData = $this->product
                ->where('status', 1)
                ->whereIn('id', $featuredProductIds)
                ->limit(8)
                ->get();

            // $featuredProductsData = $this->displayProduct::where('display_products.type', 1)
            //     ->where('display_products.store_type', 0)
            //     ->join('products', 'display_products.product_id', '=', 'products.id')
            //     ->select('products.*')
            //     ->get();

            // New Products
            $newProductIds = $this->displayProduct->where('type', 2)->where('store_type', 0)->orderBy('created_at', 'DESC')->pluck('product_id')->toArray();
            // $matchedNewProductIds = array_intersect($productIdsByStore,  $newProductIds);
            $newProductsData = $this->product
                ->where('status', 1)
                ->whereIn('id', $newProductIds)
                ->limit(8)
                ->get();

            // --
            $rsrFeaturedProductIds = $this->displayProduct->where('type', 1)->where('store_type', 1)->orderBy('created_at', 'DESC')->pluck('product_id')->toArray();
            $rsrFeaturedData = RsrProduct::whereIn('rsr_stock_number', $rsrFeaturedProductIds)->orderBy('product_description','ASC')->with('rsr_category')->get();

            // --
            $rsrNewProductIds = $this->displayProduct->where('type', 2)->where('store_type', 1)->orderBy('created_at', 'DESC')->pluck('product_id')->toArray();
            $rsrProductsData = RsrProduct::whereIn('rsr_stock_number', $rsrNewProductIds)->orderBy('product_description','ASC')->with('rsr_category')->get();
            
            // $rsrFeaturedData = RsrProduct::whereHas('rsr_category', function($query) {
            //            $query->where('status', 1);
            //         })->with('rsr_category')->limit(10)->inRandomOrder()->get();

            // $rsrProductsData = RsrProduct::whereHas('rsr_category', function($query) {
            //            $query->where('status', 1);
            //         })->with('rsr_category')->limit(10)->inRandomOrder()->get();
            
            // $rsrFeaturedData = RsrProduct::whereHas('rsr_category', function($query) {
            //            $query->where('status', 1);
            //         })->with('rsr_category')->limit(10)->inRandomOrder()->get();

            // $rsrCategories = RsrMainCategory::get();
            // dd(RsrProduct::whereNotNUll('manufacturer_id')->groupBy('manufacturer_id')->orderBy('manufacturer_id', 'ASC')->get()->pluck('full_manufacturer_name'));

        // $join = RsrProduct::limit(5)
        //     ->leftJoin('rsr_product_attributes', 'rsr_products.rsr_stock_number', '=', 'rsr_product_attributes.rsr_stock_number')
        //     ->select('rsr_products.rsr_stock_number', 'rsr_product_attributes.caliber', 'rsr_product_attributes.barrel_length')
        //     ->get();

        // dd($join);
             
            return view('site.home.index',
                compact('slider', 'sliderImage', 'featuredProductsData', 'newProductsData', 'brandsData', 'categoriesData', 'rsrMaincategoriesData', 'rsrProductsData', 'rsrFeaturedData'));
        }
        else{
            return view('site.home.maintenance');
        }
    }
}