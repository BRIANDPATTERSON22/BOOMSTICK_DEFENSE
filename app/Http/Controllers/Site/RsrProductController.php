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
use App\RsrProduct;
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

class RsrProductController extends Controller
{
    public function __construct(ProductCategory $category, ProductCategorySub $categorySub, Product $product, ProductPhoto $photo, ProductView $view, ProductColor $productColor, ProductBrand $productBrand, Advertisement $advertisement,  ProductReview $review, Size $size, ProductSize $productSize, OccasionProduct $occasionProduct, Store $store, StoreProduct $storeProduct, StoreCategory $storeCategory, SalesPerson $salesPerson, ProductHasRelatedProduct $productHasRelatedProduct, RsrProduct $rsrProduct, RsrMainCategory $rsrCategory)
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
        $this->middleware('guest');
    }

    public function index_rsr()
    {
        $module = $this->module;
        $rsrCategoriesData = $this->rsrCategory->orderBY('department_name', 'ASC')->get();
        $rsrProductsData = $this->rsrProduct->paginate(18);

        return view('site.'.$module.'.index_rsr', compact('module', 'rsrCategoriesData', 'rsrProductsData'));
    }

    public function get_single_product($id)
    {
        $module = $this->module;
        $singleData = $this->rsrProduct->where('rsr_stock_number', $id)->first();

        if (!$singleData) {
            return view('site.errors.404');
        }

        $photos = $this->photo->where('product_id', $singleData->id)->limit(10)->get();
        $otherData = $this->rsrProduct
            ->where('rsr_stock_number', '!=', $id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('site.'.$module.'.single_rsr',compact('singleData', 'module', 'photos', 'otherData'));
    }

    public function get_products_by_department($id)
    {
        $module = $this->module;

        $rsrCategoriesData = $this->rsrCategory->orderBY('department_name', 'ASC')->get();
        $rsrProductsData = $this->rsrProduct->where('department_number', $id)->paginate(18);

        if (!$rsrProductsData) {
            return view('site.errors.404');
        }

        return view('site.'.$module.'.index_rsr', compact('module', 'rsrCategoriesData', 'rsrProductsData'));
    }
}