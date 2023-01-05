<?php namespace App\Http\Controllers\Site;

use App\Product;
use App\ProductBrand;
use App\ProductModel;
use App\ProductYearMakeModel;
use App\ProductCategoryType;
use App\ProductColor;
use App\ProductSize;
use App\Color;
use App\Size;
use App\ProductCategorySub;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use Response;

class FilterController extends Controller
{
    public function __construct(Product $product, ProductBrand $brand, ProductModel $model, ProductYearMakeModel $fitman, ProductColor $productColor, Color $color, ProductCategoryType $productCategoryType, Size $size, ProductSize $productSize, ProductCategorySub $categorySub)
    {
        $this->module = "product";
        $this->data = $product;
        $this->brand = $brand;
        $this->model = $model;
        $this->fitman = $fitman;
        $this->productColor = $productColor;
        $this->color = $color;
        $this->productCategoryType = $productCategoryType;
        $this->size = $size;
        $this->productSize = $productSize;
        $this->categorySub = $categorySub;
        $this->middleware('guest');
    }

    public function post_filter(Request $request)
    {
        $year = $request->year;
        $brand = $request->brand;
        $model = $request->model;

        if($year && $brand && $model) {
            return redirect('filter/' . $year . '/' . $brand . '/' . $model);
        }elseif($year && $brand) {
            return redirect('filter/y-' . $year . '/b-' . $brand);
        }elseif($year && $model){
            return redirect('filter/y-'.$year.'/m-'.$model);
        }elseif($brand && $model){
            return redirect('filter/b-'.$brand.'/m-'.$model);
        }elseif($year){
            return redirect('filter/y-'.$year);
        }elseif($brand){
            return redirect('filter/b-'.$brand);
        }elseif($model){
            return redirect('filter/m-'.$model);
        }else{
            return redirect('products');
        }
    }

    public function get_filter1_y($year)
    {
        $module = $this->module;
        Session::put('filterYear', $year);
        Session::forget('filterBrand');
        Session::forget('filterModel');

        $allData = $this->data->where('status', 1)->where('year', 'like', $year. '%')->paginate(20);

        return view('site.'.$module.'.index', compact('allData'));
    }

    public function get_filter1_b($brand)
    {
        $module = $this->module;
        Session::put('filterBrand', $brand);
        $brandD = $this->brand->find($brand);
        Session::put('filterBrandName', $brandD->name);

        Session::forget('filterYear');
        Session::forget('filterModel');

        $allData = $this->data->where('status', 1)->where('brand_id', $brand)->paginate(20);

        return view('site.'.$module.'.index', compact('allData'));
    }

    public function get_filter1_m($model)
    {
        $module = $this->module;
        Session::put('filterModel', $model);
        $modelD = $this->model->find($model);
        Session::put('filterModelName', $modelD->name);

        Session::forget('filterBrand');
        Session::forget('filterYear');

        $allData = $this->data->where('status', 1)->where('model_id', $model)->paginate(20);

        return view('site.'.$module.'.index', compact('allData'));
    }

    public function get_filter2_yb($year, $brand)
    {
        $module = $this->module;
        Session::put('filterYear', $year);
        Session::put('filterBrand', $brand);
        $brandD = $this->brand->find($brand);
        Session::put('filterBrandName', $brandD->name);

        Session::forget('filterModel');

        $allData = $this->data->where('status', 1)
            ->where('year', 'like', $year. '%')
            ->where('brand_id', $brand)->paginate(20);

        return view('site.'.$module.'.index', compact('allData'));
    }

    public function get_filter2_ym($year, $model)
    {
        $module = $this->module;
        Session::put('filterYear', $year);
        Session::put('filterModel', $model);
        $modelD = $this->model->find($model);
        Session::put('filterModelName', $modelD->name);

        Session::forget('filterBrand');

        $allData = $this->data->where('status', 1)
            ->where('year', 'like', $year. '%')
            ->where('model_id', $model)->paginate(20);

        return view('site.'.$module.'.index', compact('allData'));
    }

    public function get_filter2_bm($brand, $model)
    {
        $module = $this->module;
        Session::put('filterBrand', $brand);
        $brandD = $this->brand->find($brand);
        Session::put('filterBrandName', $brandD->name);
        Session::put('filterModel', $model);
        $modelD = $this->model->find($model);
        Session::put('filterModelName', $modelD->name);

        Session::forget('filterYear');

        $allData = $this->data->where('status', 1)
            ->where('model_id', $model)
            ->where('brand_id', $brand)->paginate(20);

        return view('site.'.$module.'.index', compact('allData'));
    }

    public function get_filter3($year, $brand, $model)
    {
        $module = $this->module;
        Session::put('filterYear', $year);
        Session::put('filterBrand', $brand);
        $brandD = $this->brand->find($brand);
        Session::put('filterBrandName', $brandD->name);
        Session::put('filterModel', $model);
        $modelD = $this->model->find($model);
        Session::put('filterModelName', $modelD->name);

        $allData = $this->data->where('status', 1)
            ->where('year', 'like', $year. '%')
            ->where('brand_id', $brand)->where('model_id', $model)->paginate(20);

        return view('site.'.$module.'.index', compact('allData'));
    }
    
    function fetch(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
    
        $data = DB::table('products_year_make_model')
            ->where($select, $value)
            ->groupBy($dependent)
            ->get();
        $output = '<option value="">Select '.ucfirst($dependent).'</option>';

        foreach($data as $row){
            $output .= '<option value="'.$row->$dependent.'">'.$row->$dependent.'</option>';
        }
        echo $output;
    }

    public function ymd(Request $request)
    {
        $year = $request->year;
        $make = $request->make;
        $model = $request->model;

        $fitmanData = $this->fitman
            ->where('year', 'like', $year. '%')
            ->where('make', 'like', $make. '%')
            ->where('model', 'like', $model. '%')
            ->pluck('part_number')
            ->toArray();

        $allData = $this->data
            ->whereIn('part_number', $fitmanData)
            ->paginate(12);

        return view('site.product.index', compact('allData'));
    }

    public function product_filter(Request $request)
    {
        if($request->size_id){
            $searchText = $this->data->where('id', $request->size_id)->first()->size_and_symbol;
        }

        Session::put('sessionFiltersubCategoryData', $request->filter_sub_category);
        Session::put('sessionFilterBrandId', $request->brand_id);
        Session::put('sessionFilterSubCategoryTypeId', $request->sub_category_type_id);
        Session::put('sessionFilterSizeId', $request->size_id);
        Session::put('sessionFilterColorId', $request->color_id);

        $subCategory = $request->filter_sub_category;
        $brand = $request->brand_id;
        $subCategoryType = $request->sub_category_type_id;
        $size = $request->size_id;
        $color = $request->color_id;

        if($request->filter_sub_category && $request->brand_id && $request->sub_category_type_id && $request->size_id && $request->color_id) {
           return redirect('product-filter/sc-' .  $subCategory . '/b-' . $brand . '/sct-' . $subCategoryType . '/s-' . $size . '/c-' . $color);
        }
        elseif($request->filter_sub_category && $request->brand_id && $request->size_id && $request->color_id) {
            return redirect('product-filter/sc-' .  $subCategory . '/b-' . $brand . '/s-' . $size . '/c-' . $color);
        }
        elseif($request->filter_sub_category && $request->brand_id && $request->sub_category_type_id && $request->color_id) {
            return redirect('product-filter/sc-' .  $subCategory . '/b-' . $brand . '/sct-' . $subCategoryType . '/c-' . $color);
        }
        elseif($request->filter_sub_category && $request->brand_id && $request->sub_category_type_id && $request->size_id) {
            return redirect('product-filter/sc-' .  $subCategory . '/b-' . $brand . '/sct-' . $subCategoryType . '/s-' . $size);
        }
        elseif($request->brand_id && $request->sub_category_type_id && $request->size_id){
            return redirect('product-filter/b-' . $brand . '/sct-' . $subCategoryType . '/s-' . $size);
        }
        elseif($request->brand_id && $request->sub_category_type_id && $request->color_id){
            return redirect('product-filter/b-' . $brand . '/sct-' . $subCategoryType . '/c-' . $color);
        }
        elseif($request->brand_id && $request->size_id && $request->color_id){
            return redirect('product-filter/b-' . $brand . '/s-' . $size . '/c-' . $color);
        }
        elseif($request->sub_category_type_id && $request->size_id && $request->color_id){
            return redirect('product-filter/sct-' . $subCategoryType . '/s-' . $size . '/c-' . $color);
        }
        elseif($request->filter_sub_category && $request->brand_id && $request->color_id){
            return redirect('product-filter/sct-' . $subCategory . '/b-' . $brand . '/c-' . $color);
        }
        elseif($request->filter_sub_category && $request->brand_id && $request->size_id){
            return redirect('product-filter/sc-' . $subCategory . '/b-' . $brand . '/s-' . $size);
        }
        elseif($request->filter_sub_category && $request->brand_id && $request->sub_category_type_id){
            return redirect('product-filter/sc-' .  $subCategory . '/b-' . $brand . '/sct-' . $subCategoryType);
        }
        elseif($request->brand_id && $request->sub_category_type_id){
            return redirect('product-filter/b-' . $brand . '/sct-' . $subCategoryType);
        }
        elseif($request->brand_id && $request->size_id){
             return redirect('product-filter/b-' . $brand . '/s-' . $size);
        }
        elseif($request->brand_id && $request->color_id){
             return redirect('product-filter/b-' . $brand . '/c-' . $color);
        }
        elseif($request->sub_category_type_id && $request->size_id){
             return redirect('product-filter/sc-' . $subCategory . '/s-' . $size);
        }
        elseif($request->sub_category_type_id && $request->color_id){
             return redirect('product-filter/sct-' . $subCategoryType . '/c-' . $color);
        }
        elseif($request->filter_sub_category && $request->brand_id){
             return redirect('product-filter/sc-' .  $subCategory . '/b-' . $brand);
        }
        elseif($request->color_id){
             return redirect('product-filter/c-' . $color);
        }
        elseif($request->size_id){
             return redirect('product-filter/s-' . $size);
        }
        elseif($request->sub_category_type_id){
             return redirect('product-filter/sct-' . $subCategoryType);
        }
        elseif($request->brand_id){
             return redirect('product-filter/b-' . $brand);
        }
        elseif($request->filter_sub_category){
             return redirect('product-filter/sc-' .  $subCategory);
        }
        else{
            return redirect('products');
        }
        
        
        // if($request->size_id){
        //     $searchText = $this->data->where('id', $request->size_id)->first()->size_and_symbol;
        // }

        // Session::put('sessionFiltersubCategoryData', $request->filter_sub_category);
        // Session::put('sessionFilterBrandId', $request->brand_id);
        // Session::put('sessionFilterSubCategoryTypeId', $request->sub_category_type_id);
        // Session::put('sessionFilterSizeId', $request->size_id);
        // Session::put('sessionFilterColorId', $request->color_id);

        // // Session::forget('sessionFilterBrandId');
        // // Session::forget('sessionFilterSubCategoryTypeId');
        // // Session::forget('sessionFilterSizeId');
        // // Session::forget('sessionFilterColorId');

        // if($request->filter_sub_category && $request->brand_id && $request->sub_category_type_id && $request->size_id && $request->color_id) {
        //   $allData = $this->data
        //       ->where('category_id', $request->filter_sub_category)
        //       ->where('brand_id', $request->brand_id)
        //       ->where('sub_category_type_id', $request->sub_category_type_id)
        //       ->where('size_and_symbol', 'like', $searchText. '%')
        //       ->where('color_id', $request->color_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // // elseif($request->brand_id && $request->sub_category_type_id && $request->size_id && $request->color_id) {
        // //   $allData = $this->data
        // //       ->where('brand_id', $request->brand_id)
        // //       ->where('sub_category_type_id', $request->sub_category_type_id)
        // //       ->where('size_and_symbol', 'like', $searchText. '%')
        // //       ->where('color_id', $request->color_id)
        // //       ->where('status', 1)
        // //       ->paginate(18);
        // // }
        // elseif($request->filter_sub_category && $request->brand_id && $request->size_id && $request->color_id) {
        //           $allData = $this->data
        //               ->where('category_id', $request->filter_sub_category)
        //               ->where('brand_id', $request->brand_id)
        //               ->where('size_and_symbol', 'like', $searchText. '%')
        //              ->where('color_id', $request->color_id)
        //               ->where('status', 1)
        //               ->paginate(18);
        // }
        // elseif($request->filter_sub_category && $request->brand_id && $request->sub_category_type_id && $request->color_id) {
        //           $allData = $this->data
        //               ->where('category_id', $request->filter_sub_category)
        //               ->where('brand_id', $request->brand_id)
        //               ->where('sub_category_type_id', $request->sub_category_type_id)
        //              ->where('color_id', $request->color_id)
        //               ->where('status', 1)
        //               ->paginate(18);
        // }
        // elseif($request->filter_sub_category && $request->brand_id && $request->sub_category_type_id && $request->size_id) {
        //           $allData = $this->data
        //               ->where('category_id', $request->filter_sub_category)
        //               ->where('brand_id', $request->brand_id)
        //               ->where('sub_category_type_id', $request->sub_category_type_id)
        //               ->where('size_and_symbol', 'like', $searchText. '%')
        //               ->where('status', 1)
        //               ->paginate(18);
        // }
        // elseif($request->brand_id && $request->sub_category_type_id && $request->size_id){
        //   $allData = $this->data
        //       ->where('brand_id', $request->brand_id)
        //       ->where('sub_category_type_id', $request->sub_category_type_id)
        //       ->where('size_and_symbol', 'like', $searchText. '%')
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->brand_id && $request->sub_category_type_id && $request->color_id){
        //   $allData = $this->data
        //       ->where('brand_id', $request->brand_id)
        //       ->where('sub_category_type_id', $request->sub_category_type_id)
        //       ->where('color_id', $request->color_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->brand_id && $request->size_id && $request->color_id){
        //   $allData = $this->data
        //       ->where('brand_id', $request->brand_id)
        //       ->where('size_and_symbol', 'like', $searchText. '%')
        //       ->where('color_id', $request->color_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->sub_category_type_id && $request->size_id && $request->color_id){
        //     $allData = $this->data
        //         ->where('sub_category_type_id', $request->sub_category_type_id)
        //         ->where('size_and_symbol', 'like', $searchText. '%')
        //         ->where('color_id', $request->color_id)
        //         ->where('status', 1)
        //         ->paginate(18);
        // }
        // elseif($request->filter_sub_category && $request->brand_id && $request->color_id){
        //     $allData = $this->data
        //         ->where('category_id', $request->filter_sub_category)
        //         ->where('brand_id', $request->brand_id)
        //         ->where('color_id', $request->color_id)
        //         ->where('status', 1)
        //         ->paginate(18);
        // }
        // elseif($request->filter_sub_category && $request->brand_id && $request->size_id){
        //     $allData = $this->data
        //         ->where('category_id', $request->filter_sub_category)
        //         ->where('brand_id', $request->brand_id)
        //         ->where('size_and_symbol', 'like', $searchText. '%')
        //         ->where('status', 1)
        //         ->paginate(18);
        // }
        // elseif($request->filter_sub_category && $request->brand_id && $request->sub_category_type_id){
        //     $allData = $this->data
        //         ->where('category_id', $request->filter_sub_category)
        //         ->where('brand_id', $request->brand_id)
        //         ->where('sub_category_type_id', $request->sub_category_type_id)
        //         ->where('status', 1)
        //         ->paginate(18);
        // }
        // elseif($request->brand_id && $request->sub_category_type_id){
        //   $allData = $this->data
        //       ->where('brand_id', $request->brand_id)
        //       ->where('sub_category_type_id', $request->sub_category_type_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->brand_id && $request->size_id){
        //   $allData = $this->data
        //       ->where('brand_id', $request->brand_id)
        //       ->where('size_and_symbol', 'like', $searchText. '%')
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->brand_id && $request->color_id){
        //   $allData = $this->data
        //       ->where('brand_id', $request->brand_id)
        //       ->where('color_id', $request->color_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->sub_category_type_id && $request->size_id){
        //     $allData = $this->data
        //         ->where('sub_category_type_id', $request->sub_category_type_id)
        //         ->where('size_and_symbol', 'like', $searchText. '%')
        //         ->where('status', 1)
        //         ->paginate(18);
        // }
        // elseif($request->sub_category_type_id && $request->color_id){
        //   $allData = $this->data
        //       ->where('sub_category_type_id', $request->sub_category_type_id)
        //       ->where('color_id', $request->color_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->filter_sub_category && $request->brand_id){
        //   $allData = $this->data
        //       ->where('category_id', $request->filter_sub_category)
        //       ->where('brand_id', $request->brand_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->color_id){
        //   $allData = $this->data
        //       ->where('color_id', $request->color_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->size_id){
        //   $allData = $this->data
        //       ->where('size_and_symbol', 'like', $searchText. '%')
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->sub_category_type_id){
        //   $allData = $this->data
        //       ->where('sub_category_type_id', $request->sub_category_type_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->brand_id){
        //   $allData = $this->data
        //       ->where('brand_id', $request->brand_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->filter_sub_category){
        //   $allData = $this->data
        //       ->where('category_id', $request->filter_sub_category)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // else{
        //   $allData = $this->data->where('status', 1)->paginate(18);
        // }

        // return view('site.product.index', compact('allData'));


        // // dd($request->all());
        // // $filterBrandData = $this->brand->where('status', 1)->get();
        // // $filterSubCategoryTypeData = $this->productCategoryType->where('status', 1)->get();
        // // $filterColorData = $this->color->where('status', 1)->get();
        // // $filterSizeData = $this->size->where('status', 1)->get();

        // // $allData = $this->data
        // //     ->where('status', 1)
        // //     ->where('brand_id', $request->brand_id)
        // //     ->where('sub_category_type_id', $request->sub_category_type_id)
        // //     ->whereHas('productSize', function($query) {
        // //            $query->where('id', '=', request()->size_id);
        // //        })
        // //     ->whereHas('productColor', function($query) {
        // //            $query->where('id', '=', request()->color_id);
        // //        })
        // //     ->where('size_id', $request->size_id)    
        // //     ->where('color_id', $request->color_id)
        // //     ->paginate(30);

        // // $user = $this->data->newQuery();

        // // dd( $user );

        //     // Search for a user based on their name.
        //     // if ($request->has('brand_id')) {
        //     //     $user->where('brand_id', $request->input('brand_id'));
        //     // }

        //     // Search for a user based on their company.
        //     // if ($request->has('sub_category_type_id')) {
        //     //     $user->where('sub_category_type_id', $request->input('sub_category_type_id'));
        //     // }

        //     // Search for a user based on their city.
        //     // if ($request->has('city')) {
        //     //     $user->where('city', $request->input('city'));
        //     // }

        //     // Continue for all of the filters.

        //     // Get the results and return them.
        //     // $allData = $user->get();

        //     // dd( $allData );
    }
    
    
    //1c - 1
    public function get_product_filter_1_sc($subCategoryId)
    {
        $module = $this->module;

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::forget('sessionFilterBrandId');
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::forget('sessionFilterSizeId');
        Session::forget('sessionFilterColorId');

        $allData = $this->data
          ->where('category_id', $subCategoryId)
          ->where('status', 1)
          ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }
    // 1c - 2
    public function get_product_filter_1_b($brandId)
    {
        $module = $this->module;

        Session::forget('sessionFiltersubCategoryData');
        Session::put('sessionFilterBrandId', $brandId);
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::forget('sessionFilterSizeId');
        Session::forget('sessionFilterColorId');

        $allData = $this->data
            ->where('brand_id', $brandId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 1c - 3
    public function get_product_filter_1_sct($subCategoryTypeId)
    {
        $module = $this->module;

        Session::forget('sessionFiltersubCategoryData');
        Session::forget('sessionFilterBrandId');
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::forget('sessionFilterSizeId');
        Session::forget('sessionFilterColorId');

        $allData = $this->data
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 1c - 4
    public function get_product_filter_1_s($sizeId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::forget('sessionFiltersubCategoryData');
        Session::forget('sessionFilterBrandId');
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::put('sessionFilterSizeId', $sizeId);
        Session::forget('sessionFilterColorId');

        $allData = $this->data
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 1c - 5
    public function get_product_filter_1_c($colorId)
    {
        $module = $this->module;

        Session::forget('sessionFiltersubCategoryData');
        Session::forget('sessionFilterBrandId');
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::forget('sessionFilterSizeId');
        Session::put('sessionFilterColorId', $colorId);

        $allData = $this->data
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 2c - 1
    public function get_product_filter_2_sc_b($subCategoryId, $brandId)
    {
        $module = $this->module;

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::put('sessionFilterBrandId', $brandId);
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::forget('sessionFilterSizeId');
        Session::forget('sessionFilterColorId');

        $allData = $this->data
             ->where('category_id', $subCategoryId)
             ->where('brand_id', $brandId)
             ->where('status', 1)
             ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }


    // 2c -2
    public function get_product_filter_2_sct_c($subCategoryTypeId, $colorId)
    {
        $module = $this->module;

        Session::forget('sessionFiltersubCategoryData');
        Session::forget('sessionFilterBrandId');
        Session::forget('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::forget('sessionFilterSizeId');
        Session::put('sessionFilterColorId', $colorId);

        $allData = $this->data
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 2c -3 
    public function get_product_filter_2_sct_s($subCategoryTypeId, $sizeId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::forget('sessionFiltersubCategoryData');
        Session::forget('sessionFilterBrandId');
        Session::forget('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::put('sessionFilterSizeId', $sizeId);
        Session::put('sessionFilterColorId');

        $allData = $this->data
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 2c- 4
    public function get_product_filter_2_b_c($brandId, $colorId)
    {
        $module = $this->module;

        Session::forget('sessionFiltersubCategoryData');
        Session::put('sessionFilterBrandId', $brandId);
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::forget('sessionFilterSizeId');
        Session::put('sessionFilterColorId', $colorId);

        $allData = $this->data
              ->where('brand_id', $brandId)
              ->where('color_id', $colorId)
              ->where('status', 1)
              ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 2c - 5
    public function get_product_filter_2_b_s($brandId, $sizeId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::forget('sessionFiltersubCategoryData');
        Session::put('sessionFilterBrandId', $brandId);
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::put('sessionFilterSizeId', $sizeId);
        Session::forget('sessionFilterColorId');

        $allData = $this->data
            ->where('brand_id', $brandId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 2c - 6 
    public function get_product_filter_2_b_sct($brandId, $subCategoryTypeId)
    {
        $module = $this->module;

        Session::forget('sessionFiltersubCategoryData');
        Session::put('sessionFilterBrandId', $brandId);
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::forget('sessionFilterSizeId');
        Session::forget('sessionFilterColorId');

        $allData = $this->data
            ->where('brand_id', $brandId)
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }


    // 3c -1
    public function get_product_filter_3_sc_b_sct($subCategoryId, $brandId, $subCategoryTypeId)
    {
        $module = $this->module;

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::put('sessionFilterBrandId', $brandId);
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::forget('sessionFilterSizeId');
        Session::forget('sessionFilterColorId');

        $allData = $this->data
                ->where('category_id', $subCategoryId)
                ->where('brand_id', $brandId)
                ->where('sub_category_type_id', $subCategoryTypeId)
                ->where('status', 1)
                ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 3c -2 
    public function get_product_filter_3_sct_b_s($subCategoryId, $brandId, $sizeId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::put('sessionFilterBrandId', $brandId);
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::put('sessionFilterSizeId', $sizeId);
        Session::forget('sessionFilterColorId');

        $allData = $this->data
            ->where('category_id', $subCategoryId)
            ->where('brand_id', $brandId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 3c -3 
    public function get_product_filter_3_sc_b_c($subCategoryId, $brandId, $colorId)
    {
        $module = $this->module;

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::put('sessionFilterBrandId', $brandId);
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::forget('sessionFilterSizeId');
        Session::put('sessionFilterColorId', $colorId);

        $allData = $this->data
            ->where('category_id', $subCategoryId)
            ->where('brand_id', $brandId)
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 3c -4 
    public function get_product_filter_3_sct_s_s($subCategoryTypeId, $sizeId, $colorId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::forget('sessionFiltersubCategoryData');
        Session::forget('sessionFilterBrandId');
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::put('sessionFilterSizeId', $sizeId);
        Session::put('sessionFilterColorId', $colorId);

       $allData = $this->data
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 3c -5 
    public function get_product_filter_3_b_s_c($brandId, $sizeId, $colorId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::forget('sessionFiltersubCategoryData');
        Session::put('sessionFilterBrandId', $brandId);
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::put('sessionFilterSizeId', $sizeId);
        Session::put('sessionFilterColorId', $colorId);

       $allData = $this->data
            ->where('brand_id', $brandId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 3c -6 
    public function get_product_filter_3_b_sct_c($brandId, $subCategoryTypeId, $colorId)
    {
        $module = $this->module;

        Session::forget('sessionFiltersubCategoryData');
        Session::put('sessionFilterBrandId', $brandId);
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::forget('sessionFilterSizeId');
        Session::put('sessionFilterColorId', $colorId);

       $allData = $this->data
            ->where('brand_id', $brandId)
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 3c -7 
    public function get_product_filter_3_b_sct_s($brandId, $subCategoryTypeId, $sizeId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::forget('sessionFiltersubCategoryData');
        Session::put('sessionFilterBrandId', $brandId);
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::put('sessionFilterSizeId', $sizeId);
        Session::forget('sessionFilterColorId');

       $allData = $this->data
            ->where('brand_id', $brandId)
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }


    // 4c - 1
    public function get_product_filter_4_sc_b_sct_s($subCategoryId, $brandId, $subCategoryTypeId, $sizeId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::put('sessionFilterBrandId', $brandId);
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::put('sessionFilterSizeId', $sizeId);
        Session::forget('sessionFilterColorId');

        $allData = $this->data
            ->where('category_id', $subCategoryId)
            ->where('brand_id', $brandId)
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 4c - 2
    public function get_product_filter_4_sct_b_sct_c($subCategoryId, $brandId, $subCategoryTypeId, $colorId)
    {
        $module = $this->module;

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::put('sessionFilterBrandId', $brandId);
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::forget('sessionFilterSizeId');
        Session::put('sessionFilterColorId', $colorId);

        $allData = $this->data
            ->where('category_id', $subCategoryId)
            ->where('brand_id', $brandId)
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 4c - 3
    public function get_product_filter_4_sc_b_s_c($subCategoryId, $brandId, $sizeId, $colorId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::put('sessionFilterBrandId', $brandId);
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::put('sessionFilterSizeId', $sizeId);
        Session::put('sessionFilterColorId', $colorId);

        $allData = $this->data
            ->where('category_id', $subCategoryId)
            ->where('brand_id', $brandId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }


    // 5c -1
    public function get_product_filter_5_sc_b_sct_c($subCategoryId, $brandId, $subCategoryTypeId, $sizeId, $colorId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::put('sessionFilterBrandId', $brandId);
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::put('sessionFilterSizeId', $sizeId);
        Session::put('sessionFilterColorId', $colorId);

        $allData = $this->data
            ->where('category_id', $subCategoryId)
            ->where('brand_id', $brandId)
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    public function brand_filter(Request $request)
    {
        if($request->size_id){
            $searchText = $this->data->where('id', $request->size_id)->first()->size_and_symbol;
        }

        Session::put('sessionFiltersubCategoryData', $request->filter_sub_category);
        Session::put('sessionFilterBrandId', $request->brand_id);
        Session::put('sessionFilterSubCategoryTypeId', $request->sub_category_type_id);
        Session::put('sessionFilterSizeId', $request->size_id);
        Session::put('sessionFilterColorId', $request->color_id);

        $subCategory = $request->filter_sub_category;
        $brand = $request->brand_id;
        $subCategoryType = $request->sub_category_type_id;
        $size = $request->size_id;
        $color = $request->color_id;

        if($request->filter_sub_category && $request->brand_id && $request->sub_category_type_id && $request->size_id && $request->color_id) {
           return redirect('brand-filter/sc-' .  $subCategory . '/b-' . $brand . '/sct-' . $subCategoryType . '/s-' . $size . '/c-' . $color);
        }
        elseif($request->filter_sub_category && $request->brand_id && $request->size_id && $request->color_id) {
            return redirect('brand-filter/sc-' .  $subCategory . '/b-' . $brand . '/s-' . $size . '/c-' . $color);
        }
        elseif($request->filter_sub_category && $request->brand_id && $request->sub_category_type_id && $request->color_id) {
            return redirect('brand-filter/sc-' .  $subCategory . '/b-' . $brand . '/sct-' . $subCategoryType . '/c-' . $color);
        }
        elseif($request->filter_sub_category && $request->brand_id && $request->sub_category_type_id && $request->size_id) {
            return redirect('brand-filter/sc-' .  $subCategory . '/b-' . $brand . '/sct-' . $subCategoryType . '/s-' . $size);
        }
        elseif($request->brand_id && $request->sub_category_type_id && $request->size_id){
            return redirect('brand-filter/b-' . $brand . '/sct-' . $subCategoryType . '/s-' . $size);
        }
        elseif($request->brand_id && $request->sub_category_type_id && $request->color_id){
            return redirect('brand-filter/b-' . $brand . '/sct-' . $subCategoryType . '/c-' . $color);
        }
        elseif($request->brand_id && $request->size_id && $request->color_id){
            return redirect('brand-filter/b-' . $brand . '/s-' . $size . '/c-' . $color);
        }
        elseif($request->sub_category_type_id && $request->size_id && $request->color_id){
            return redirect('brand-filter/sct-' . $subCategoryType . '/s-' . $size . '/c-' . $color);
        }
        elseif($request->filter_sub_category && $request->brand_id && $request->color_id){
            return redirect('brand-filter/sct-' . $subCategory . '/b-' . $brand . '/c-' . $color);
        }
        elseif($request->filter_sub_category && $request->brand_id && $request->size_id){
            return redirect('brand-filter/sc-' . $subCategory . '/b-' . $brand . '/s-' . $size);
        }
        elseif($request->filter_sub_category && $request->brand_id && $request->sub_category_type_id){
            return redirect('brand-filter/sc-' .  $subCategory . '/b-' . $brand . '/sct-' . $subCategoryType);
        }
        elseif($request->brand_id && $request->sub_category_type_id){
            return redirect('brand-filter/b-' . $brand . '/sct-' . $subCategoryType);
        }
        elseif($request->brand_id && $request->size_id){
             return redirect('brand-filter/b-' . $brand . '/s-' . $size);
        }
        elseif($request->brand_id && $request->color_id){
             return redirect('brand-filter/b-' . $brand . '/c-' . $color);
        }
        elseif($request->sub_category_type_id && $request->size_id){
             return redirect('brand-filter/sc-' . $subCategory . '/s-' . $size);
        }
        elseif($request->sub_category_type_id && $request->color_id){
             return redirect('brand-filter/sct-' . $subCategoryType . '/c-' . $color);
        }
        elseif($request->filter_sub_category && $request->brand_id){
             return redirect('brand-filter/sc-' .  $subCategory . '/b-' . $brand);
        }
        elseif($request->color_id){
             return redirect('brand-filter/c-' . $color);
        }
        elseif($request->size_id){
             return redirect('brand-filter/s-' . $size);
        }
        elseif($request->sub_category_type_id){
             return redirect('brand-filter/sct-' . $subCategoryType);
        }
        elseif($request->brand_id){
             return redirect('brand-filter/b-' . $brand);
        }
        elseif($request->filter_sub_category){
             return redirect('brand-filter/sc-' .  $subCategory);
        }
        else{
            return redirect('products');
        }
        
        // if($request->size_id){
        //     $searchText = $this->data->where('id', $request->size_id)->first()->size_and_symbol;
        // }

        // Session::put('sessionFiltersubCategoryData', $request->filter_sub_category);
        // Session::put('sessionFilterBrandId', $request->brand_id);
        // Session::put('sessionFilterSubCategoryTypeId', $request->sub_category_type_id);
        // Session::put('sessionFilterSizeId', $request->size_id);
        // Session::put('sessionFilterColorId', $request->color_id);

        // if($request->filter_sub_category && $request->brand_id && $request->sub_category_type_id && $request->size_id && $request->color_id) {
        //   $allData = $this->data
        //       ->where('category_id', $request->filter_sub_category)
        //       ->where('brand_id', $request->brand_id)
        //       ->where('sub_category_type_id', $request->sub_category_type_id)
        //       ->where('size_and_symbol', 'like', $searchText. '%')
        //       ->where('color_id', $request->color_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->filter_sub_category && $request->brand_id && $request->size_id && $request->color_id) {
        //           $allData = $this->data
        //               ->where('category_id', $request->filter_sub_category)
        //               ->where('brand_id', $request->brand_id)
        //               ->where('size_and_symbol', 'like', $searchText. '%')
        //              ->where('color_id', $request->color_id)
        //               ->where('status', 1)
        //               ->paginate(18);
        // }
        // elseif($request->filter_sub_category && $request->brand_id && $request->sub_category_type_id && $request->color_id) {
        //           $allData = $this->data
        //               ->where('category_id', $request->filter_sub_category)
        //               ->where('brand_id', $request->brand_id)
        //               ->where('sub_category_type_id', $request->sub_category_type_id)
        //              ->where('color_id', $request->color_id)
        //               ->where('status', 1)
        //               ->paginate(18);
        // }
        // elseif($request->filter_sub_category && $request->brand_id && $request->sub_category_type_id && $request->size_id) {
        //           $allData = $this->data
        //               ->where('category_id', $request->filter_sub_category)
        //               ->where('brand_id', $request->brand_id)
        //               ->where('sub_category_type_id', $request->sub_category_type_id)
        //               ->where('size_and_symbol', 'like', $searchText. '%')
        //               ->where('status', 1)
        //               ->paginate(18);
        // }
        // elseif($request->brand_id && $request->sub_category_type_id && $request->size_id){
        //   $allData = $this->data
        //       ->where('brand_id', $request->brand_id)
        //       ->where('sub_category_type_id', $request->sub_category_type_id)
        //       ->where('size_and_symbol', 'like', $searchText. '%')
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->brand_id && $request->sub_category_type_id && $request->color_id){
        //   $allData = $this->data
        //       ->where('brand_id', $request->brand_id)
        //       ->where('sub_category_type_id', $request->sub_category_type_id)
        //       ->where('color_id', $request->color_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->brand_id && $request->size_id && $request->color_id){
        //   $allData = $this->data
        //       ->where('brand_id', $request->brand_id)
        //       ->where('size_and_symbol', 'like', $searchText. '%')
        //       ->where('color_id', $request->color_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->sub_category_type_id && $request->size_id && $request->color_id){
        //     $allData = $this->data
        //         ->where('sub_category_type_id', $request->sub_category_type_id)
        //         ->where('size_and_symbol', 'like', $searchText. '%')
        //         ->where('color_id', $request->color_id)
        //         ->where('status', 1)
        //         ->paginate(18);
        // }
        // elseif($request->filter_sub_category && $request->brand_id && $request->color_id){
        //     $allData = $this->data
        //         ->where('category_id', $request->filter_sub_category)
        //         ->where('brand_id', $request->brand_id)
        //         ->where('color_id', $request->color_id)
        //         ->where('status', 1)
        //         ->paginate(18);
        // }
        // elseif($request->filter_sub_category && $request->brand_id && $request->size_id){
        //     $allData = $this->data
        //         ->where('category_id', $request->filter_sub_category)
        //         ->where('brand_id', $request->brand_id)
        //         ->where('size_and_symbol', 'like', $searchText. '%')
        //         ->where('status', 1)
        //         ->paginate(18);
        // }
        // elseif($request->filter_sub_category && $request->brand_id && $request->sub_category_type_id){
        //     $allData = $this->data
        //         ->where('category_id', $request->filter_sub_category)
        //         ->where('brand_id', $request->brand_id)
        //         ->where('sub_category_type_id', $request->sub_category_type_id)
        //         ->where('status', 1)
        //         ->paginate(18);
        // }
        // elseif($request->brand_id && $request->sub_category_type_id){
        //   $allData = $this->data
        //       ->where('brand_id', $request->brand_id)
        //       ->where('sub_category_type_id', $request->sub_category_type_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->brand_id && $request->size_id){
        //   $allData = $this->data
        //       ->where('brand_id', $request->brand_id)
        //       ->where('size_and_symbol', 'like', $searchText. '%')
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->brand_id && $request->color_id){
        //   $allData = $this->data
        //       ->where('brand_id', $request->brand_id)
        //       ->where('color_id', $request->color_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->sub_category_type_id && $request->size_id){
        //     $allData = $this->data
        //         ->where('sub_category_type_id', $request->sub_category_type_id)
        //         ->where('size_and_symbol', 'like', $searchText. '%')
        //         ->where('status', 1)
        //         ->paginate(18);
        // }
        // elseif($request->sub_category_type_id && $request->color_id){
        //   $allData = $this->data
        //       ->where('sub_category_type_id', $request->sub_category_type_id)
        //       ->where('color_id', $request->color_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->filter_sub_category && $request->brand_id){
        //   $allData = $this->data
        //       ->where('category_id', $request->filter_sub_category)
        //       ->where('brand_id', $request->brand_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->color_id){
        //   $allData = $this->data
        //       ->where('color_id', $request->color_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->size_id){
        //   $allData = $this->data
        //       ->where('size_and_symbol', 'like', $searchText. '%')
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->sub_category_type_id){
        //   $allData = $this->data
        //       ->where('sub_category_type_id', $request->sub_category_type_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->brand_id){
        //   $allData = $this->data
        //       ->where('brand_id', $request->brand_id)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // elseif($request->filter_sub_category){
        //   $allData = $this->data
        //       ->where('category_id', $request->filter_sub_category)
        //       ->where('status', 1)
        //       ->paginate(18);
        // }
        // else{
        //   $allData = $this->data->where('status', 1)->paginate(18);
        // }
        // return view('site.product.index', compact('allData'));
    }
    
    
    //1c - 1
    public function get_brand_filter_1_sc($subCategoryId)
    {
        $module = $this->module;

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::forget('sessionFilterBrandId');
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::forget('sessionFilterSizeId');
        Session::forget('sessionFilterColorId');

        $allData = $this->data
          ->where('category_id', $subCategoryId)
          ->where('status', 1)
          ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }
    // 1c - 2
    public function get_brand_filter_1_b($brandId)
    {
        $module = $this->module;

        Session::forget('sessionFiltersubCategoryData');
        Session::put('sessionFilterBrandId', $brandId);
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::forget('sessionFilterSizeId');
        Session::forget('sessionFilterColorId');

        $allData = $this->data
            ->where('brand_id', $brandId)
            ->whereHas('category', function($query) {
                   $query->where('status', 1);
                })
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 1c - 3
    public function get_brand_filter_1_sct($subCategoryTypeId)
    {
        $module = $this->module;

        Session::forget('sessionFiltersubCategoryData');
        Session::forget('sessionFilterBrandId');
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::forget('sessionFilterSizeId');
        Session::forget('sessionFilterColorId');

        $allData = $this->data
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 1c - 4
    public function get_brand_filter_1_s($sizeId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::forget('sessionFiltersubCategoryData');
        Session::forget('sessionFilterBrandId');
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::put('sessionFilterSizeId', $sizeId);
        Session::forget('sessionFilterColorId');

        $allData = $this->data
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 1c - 5
    public function get_brand_filter_1_c($colorId)
    {
        $module = $this->module;

        Session::forget('sessionFiltersubCategoryData');
        Session::forget('sessionFilterBrandId');
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::forget('sessionFilterSizeId');
        Session::put('sessionFilterColorId', $colorId);

        $allData = $this->data
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 2c - 1
    public function get_brand_filter_2_sc_b($subCategoryId, $brandId)
    {
        $module = $this->module;

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::put('sessionFilterBrandId', $brandId);
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::forget('sessionFilterSizeId');
        Session::forget('sessionFilterColorId');

        $allData = $this->data
             ->where('category_id', $subCategoryId)
             ->where('brand_id', $brandId)
             ->where('status', 1)
             ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }


    // 2c -2
    public function get_brand_filter_2_sct_c($subCategoryTypeId, $colorId)
    {
        $module = $this->module;

        Session::forget('sessionFiltersubCategoryData');
        Session::forget('sessionFilterBrandId');
        Session::forget('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::forget('sessionFilterSizeId');
        Session::put('sessionFilterColorId', $colorId);

        $allData = $this->data
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 2c -3 
    public function get_brand_filter_2_sct_s($subCategoryTypeId, $sizeId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::forget('sessionFiltersubCategoryData');
        Session::forget('sessionFilterBrandId');
        Session::forget('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::put('sessionFilterSizeId', $sizeId);
        Session::put('sessionFilterColorId');

        $allData = $this->data
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 2c- 4
    public function get_brand_filter_2_b_c($brandId, $colorId)
    {
        $module = $this->module;

        Session::forget('sessionFiltersubCategoryData');
        Session::put('sessionFilterBrandId', $brandId);
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::forget('sessionFilterSizeId');
        Session::put('sessionFilterColorId', $colorId);

        $allData = $this->data
              ->where('brand_id', $brandId)
              ->where('color_id', $colorId)
              ->where('status', 1)
              ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 2c - 5
    public function get_brand_filter_2_b_s($brandId, $sizeId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::forget('sessionFiltersubCategoryData');
        Session::put('sessionFilterBrandId', $brandId);
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::put('sessionFilterSizeId', $sizeId);
        Session::forget('sessionFilterColorId');

        $allData = $this->data
            ->where('brand_id', $brandId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 2c - 6 
    public function get_brand_filter_2_b_sct($brandId, $subCategoryTypeId)
    {
        $module = $this->module;

        Session::forget('sessionFiltersubCategoryData');
        Session::put('sessionFilterBrandId', $brandId);
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::forget('sessionFilterSizeId');
        Session::forget('sessionFilterColorId');

        $allData = $this->data
            ->where('brand_id', $brandId)
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }


    // 3c -1
    public function get_brand_filter_3_sc_b_sct($subCategoryId, $brandId, $subCategoryTypeId)
    {
        $module = $this->module;

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::put('sessionFilterBrandId', $brandId);
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::forget('sessionFilterSizeId');
        Session::forget('sessionFilterColorId');

        $allData = $this->data
                ->where('category_id', $subCategoryId)
                ->where('brand_id', $brandId)
                ->where('sub_category_type_id', $subCategoryTypeId)
                ->where('status', 1)
                ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 3c -2 
    public function get_brand_filter_3_sct_b_s($subCategoryId, $brandId, $sizeId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::put('sessionFilterBrandId', $brandId);
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::put('sessionFilterSizeId', $sizeId);
        Session::forget('sessionFilterColorId');

        $allData = $this->data
            ->where('category_id', $subCategoryId)
            ->where('brand_id', $brandId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 3c -3 
    public function get_brand_filter_3_sc_b_c($subCategoryId, $brandId, $colorId)
    {
        $module = $this->module;

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::put('sessionFilterBrandId', $brandId);
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::forget('sessionFilterSizeId');
        Session::put('sessionFilterColorId', $colorId);

        $allData = $this->data
            ->where('category_id', $subCategoryId)
            ->where('brand_id', $brandId)
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 3c -4 
    public function get_brand_filter_3_sct_s_s($subCategoryTypeId, $sizeId, $colorId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::forget('sessionFiltersubCategoryData');
        Session::forget('sessionFilterBrandId');
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::put('sessionFilterSizeId', $sizeId);
        Session::put('sessionFilterColorId', $colorId);

       $allData = $this->data
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 3c -5 
    public function get_brand_filter_3_b_s_c($brandId, $sizeId, $colorId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::forget('sessionFiltersubCategoryData');
        Session::put('sessionFilterBrandId', $brandId);
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::put('sessionFilterSizeId', $sizeId);
        Session::put('sessionFilterColorId', $colorId);

       $allData = $this->data
            ->where('brand_id', $brandId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 3c -6 
    public function get_brand_filter_3_b_sct_c($brandId, $subCategoryTypeId, $colorId)
    {
        $module = $this->module;

        Session::forget('sessionFiltersubCategoryData');
        Session::put('sessionFilterBrandId', $brandId);
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::forget('sessionFilterSizeId');
        Session::put('sessionFilterColorId', $colorId);

       $allData = $this->data
            ->where('brand_id', $brandId)
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 3c -7 
    public function get_brand_filter_3_b_sct_s($brandId, $subCategoryTypeId, $sizeId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::forget('sessionFiltersubCategoryData');
        Session::put('sessionFilterBrandId', $brandId);
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::put('sessionFilterSizeId', $sizeId);
        Session::forget('sessionFilterColorId');

       $allData = $this->data
            ->where('brand_id', $brandId)
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }


    // 4c - 1
    public function get_brand_filter_4_sc_b_sct_s($subCategoryId, $brandId, $subCategoryTypeId, $sizeId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::put('sessionFilterBrandId', $brandId);
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::put('sessionFilterSizeId', $sizeId);
        Session::forget('sessionFilterColorId');

        $allData = $this->data
            ->where('category_id', $subCategoryId)
            ->where('brand_id', $brandId)
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 4c - 2
    public function get_brand_filter_4_sct_b_sct_c($subCategoryId, $brandId, $subCategoryTypeId, $colorId)
    {
        $module = $this->module;

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::put('sessionFilterBrandId', $brandId);
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::forget('sessionFilterSizeId');
        Session::put('sessionFilterColorId', $colorId);

        $allData = $this->data
            ->where('category_id', $subCategoryId)
            ->where('brand_id', $brandId)
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }

    // 4c - 3
    public function get_brand_filter_4_sc_b_s_c($subCategoryId, $brandId, $sizeId, $colorId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::put('sessionFilterBrandId', $brandId);
        Session::forget('sessionFilterSubCategoryTypeId');
        Session::put('sessionFilterSizeId', $sizeId);
        Session::put('sessionFilterColorId', $colorId);

        $allData = $this->data
            ->where('category_id', $subCategoryId)
            ->where('brand_id', $brandId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }


    // Brand Filter - 5c -1
    public function get_brand_filter_5_sc_b_sct_c($subCategoryId, $brandId, $subCategoryTypeId, $sizeId, $colorId)
    {
        $module = $this->module;

        if($sizeId){
            $searchText = $this->data->where('id', $sizeId)->first()->size_and_symbol;
        }

        Session::put('sessionFiltersubCategoryData', $subCategoryId);
        Session::put('sessionFilterBrandId', $brandId);
        Session::put('sessionFilterSubCategoryTypeId', $subCategoryTypeId);
        Session::put('sessionFilterSizeId', $sizeId);
        Session::put('sessionFilterColorId', $colorId);

        $allData = $this->data
            ->where('category_id', $subCategoryId)
            ->where('brand_id', $brandId)
            ->where('sub_category_type_id', $subCategoryTypeId)
            ->where('size_and_symbol', 'like', $searchText. '%')
            ->where('color_id', $colorId)
            ->where('status', 1)
            ->paginate(18);

        return view('site.'.$module.'.index', compact('allData'));
    }
    

    public function ajax_sub_category($id)
    {
      $brandIds = $this->data
        ->where('status', 1)
        ->where('category_id', $id)
        ->pluck('brand_id')
        ->toArray();

      $brands = $this->brand
        ->where('status', 1)  
        ->whereIn('id', $brandIds)
        ->pluck('name', 'id');

      return json_encode($brands);  
    }

    public function ajax_brand($id, $cid)
    {
      // Sub category Type
      $subCategoryTypeIds = $this->data
        ->where('status', 1)
        ->where('category_id', $cid)
        ->where('brand_id', $id)
        ->pluck('sub_category_type_id')
        ->toArray();
      $subCategoryTypes = $this->productCategoryType
        ->where('status', 1)
        ->whereIn('id', $subCategoryTypeIds)
        ->pluck('name', 'id');

      // Size
      $measurements = $this->data
          ->where('status', 1)
          ->where('category_id', $cid)
          ->where('brand_id', $id)
          ->whereNotNull('size_and_symbol')
          ->groupBy('size_and_symbol')
          ->pluck('size_and_symbol','id')
          ->toArray();

      // Color
      $colorIds = $this->data
          ->where('status', 1)
          ->where('category_id', $cid)
          ->where('brand_id', $id)
          ->pluck('color_id')
          ->toArray();
          
       $colors= $this->color
          ->where('status', 1)
          ->whereIn('id', $colorIds)
          ->pluck('name', 'id');

          // session()->put('sessionSubCategoryTypesJs', $subCategoryTypes);
          // session()->put('sessionColorIdsJs', $colors);
          // return json_encode($subCategoryTypes);
          return Response::json(array('subCategoryTypes'=>$subCategoryTypes,'colors'=>$colors, 'measurements'=>$measurements));
    }

    public function ajax_type($id, $cid, $bid)
    {
      $sub_category_type_ids = $this->data
        ->where('status', 1)
        ->where('category_id', $cid)
        ->where('brand_id', $bid)
        ->where('sub_category_type_id', $id)
        ->pluck('measurement_id')
        ->toArray();

        // $measurements = $this->data
        //   ->select('id','sub_category_type_id','size_and_symbol', 'measurement' , DB::raw('CONCAT(measurement, "-", measurement_id) AS mixed'))
        //   ->where('sub_category_type_id', $id)
        //   ->groupBy('size_and_symbol')
        //   ->pluck('size_and_symbol','id')
        //   ->toArray();

      $measurements = $this->data
        ->where('status', 1)
        ->where('category_id', $cid)
        ->where('brand_id', $bid)
        ->where('sub_category_type_id', $id)
        ->whereNotNull('size_and_symbol')
        ->groupBy('size_and_symbol')
        // ->pluck('size_and_symbol','id')
        // ->toArray();
        ->get();
        
     $measurements = $measurements->sortBy('measurement')->pluck('size_and_symbol','id')->toArray();
        

    //   dd( $measurements );
    // $sub_category_types = $this->size->where('status', 1)->whereIn('id', $sub_category_type_ids)->pluck('name', 'id');
    
    // $sub_category_types = $this->size->select('id', DB::raw("concat(name, ' - ',measurement_type) as id_name"))
    //                   ->orderBy('name')
    //                   ->pluck('id_name', 'id');
    // dd( $sub_category_types);
      return json_encode($measurements);
    }

    public function ajax_size($id)
    {
      $singleProduct = $this->data->where('id', $id)->first();

      $colorIds = $this->data
        ->where('status', 1)
        ->where('category_id', $singleProduct->category_id)
        ->where('brand_id', $singleProduct->brand_id)
        ->where('sub_category_type_id', $singleProduct->sub_category_type_id)
        ->where('size_and_symbol', $singleProduct->size_and_symbol)
        ->pluck('color_id')
        ->toArray();

      $productColors = $this->color
        ->where('status', 1)
        ->whereIn('id', $colorIds)
        ->pluck('name', 'id');

      return json_encode($productColors);
    }

    public function reset_filter()
    {
      session()->forget('sessionFiltersubCategoryData');
      session()->forget('sessionFilterBrandId');
      session()->forget('sessionFilterSubCategoryTypeId');
      session()->forget('sessionFilterSizeId');
      session()->forget('sessionFilterColorId');

      return redirect()->back()->with('success', 'Filter has been reset.');
    }

    // brand to sub category
    public function ajax_brand_2($id)
    {
      $subCategoriesIds = $this->data
        ->where('status', 1)
        ->where('brand_id', $id)
        ->pluck('category_id')
        ->toArray();

      $subCategories = $this->categorySub
        ->where('status', 1)  
        ->whereIn('id', $subCategoriesIds)
        ->pluck('name', 'id');

      return json_encode($subCategories);  
    }

    // SubCategory to 1.sub category type 2.size 3.color
    public function ajax_sub_category_2($id, $cid)
    {
      // Sub category Type
      $subCategoryTypeIds = $this->data
        ->where('status', 1)
        ->where('category_id', $cid)
        ->where('brand_id', $id)
        ->pluck('sub_category_type_id')
        ->toArray();
      $subCategoryTypes = $this->productCategoryType
        ->where('status', 1)
        ->whereIn('id', $subCategoryTypeIds)
        ->pluck('name', 'id');

      // Size
      $measurements = $this->data
          ->where('status', 1)
          ->where('category_id', $cid)
          ->where('brand_id', $id)
          ->whereNotNull('size_and_symbol')
          ->groupBy('size_and_symbol')
          ->pluck('size_and_symbol','id')
          ->toArray();

      // Color
      $colorIds = $this->data
            ->where('status', 1)
          ->where('category_id', $cid)
          ->where('brand_id', $id)
          ->pluck('color_id')
          ->toArray();
          
       $colors= $this->color
          ->where('status', 1)
          ->whereIn('id', $colorIds)
          ->pluck('name', 'id');

          return Response::json(array('subCategoryTypes'=>$subCategoryTypes,'colors'=>$colors, 'measurements'=>$measurements));
    }


}