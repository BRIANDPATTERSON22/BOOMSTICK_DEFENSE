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

class FilterControllerOld extends Controller
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
        $searchText = $this->data->where('id', $request->size_id)->first()->size_and_symbol;

        Session::put('sessionFilterBrandId', $request->brand_id);
        Session::put('sessionFilterSubCategoryTypeId', $request->sub_category_type_id);
        Session::put('sessionFilterSizeId', $request->size_id);
        Session::put('sessionFilterColorId', $request->color_id);

        // Session::forget('sessionFilterBrandId');
        // Session::forget('sessionFilterSubCategoryTypeId');
        // Session::forget('sessionFilterSizeId');
        // Session::forget('sessionFilterColorId');

        // if ($request->brand_id) {
        //     $sessionFilterBrand = $this->brand->find($request->brand_id);
        //     Session::put('sessionFilterBrandName', $sessionFilterBrand->name);
        // }
        // if ($request->sub_category_type_id) {
        //     $sessionFilterSubCategoryType = $this->productCategoryType->find($request->sub_category_type_id);
        //     Session::put('sessionFilterSubCategoryTypeName', $sessionFilterSubCategoryType->name);
        // }
        // if ($request->size_id) {
        //     $sessionFilterSize = $this->size->find($request->size_id);
        //     Session::put('sessionFilterSizeName', $sessionFilterSize->name);
        // }
        // if ($request->color_id) {
        //     $sessionFilterColor = $this->color->find($request->color_id);
        //     Session::put('sessionFilterColorName', $sessionFilterColor->name);
        // }




        if($request->brand_id && $request->sub_category_type_id && $request->size_id && $request->color_id) {
            // $allData = $this->data
            //     ->where('brand_id', $request->brand_id)
            //     ->where('sub_category_type_id', $request->sub_category_type_id)
            //     ->whereHas('productSize', function($query) {
            //         $query->where('size_id', '=', request()->size_id);
            //     })
            //     ->whereHas('productColor', function($query) {
            //         $query->where('color_id', '=', request()->color_id);
            //     })
            //     ->where('status', 1)
            //     ->paginate(18);
          $allData = $this->data
              ->where('brand_id', $request->brand_id)
              ->where('sub_category_type_id', $request->sub_category_type_id)
              ->where('size_and_symbol', 'like', $searchText. '%')
              ->where('color_id', $request->color_id)
              ->where('status', 1)
              ->paginate(18);
        }
        elseif($request->brand_id && $request->sub_category_type_id && $request->size_id){
            $allData = $this->data
                ->where('brand_id', $request->brand_id)
                ->where('sub_category_type_id', $request->sub_category_type_id)
                ->whereHas('productSize', function($query) {
                    $query->where('size_id', '=', request()->size_id);
                })
                ->where('status', 1)
                ->paginate(18);
        }
        elseif($request->brand_id && $request->sub_category_type_id && $request->color_id){
          $allData = $this->data
              ->where('brand_id', $request->brand_id)
              ->where('sub_category_type_id', $request->sub_category_type_id)
              ->whereHas('productColor', function($query) {
                  $query->where('color_id', '=', request()->color_id);
              })
              ->where('status', 1)
              ->paginate(18);
        }
        elseif($request->brand_id && $request->size_id && $request->color_id){
              $allData = $this->data
                  ->where('brand_id', $request->brand_id)
                    ->whereHas('productSize', function($query) {
                        $query->where('size_id', '=', request()->size_id);
                    })
                  ->whereHas('productColor', function($query) {
                      $query->where('color_id', '=', request()->color_id);
                  })
                  ->where('status', 1)
                  ->paginate(18);
        }
        elseif($request->sub_category_type_id && $request->size_id && $request->color_id){
              $allData = $this->data
                  ->where('sub_category_type_id', $request->sub_category_type_id)
                    ->whereHas('productSize', function($query) {
                        $query->where('size_id', '=', request()->size_id);
                    })
                  ->whereHas('productColor', function($query) {
                      $query->where('color_id', '=', request()->color_id);
                  })
                  ->where('status', 1)
                  ->paginate(18);
        }
        elseif($request->brand_id && $request->sub_category_type_id){
          $allData = $this->data
              ->where('brand_id', $request->brand_id)
              ->where('sub_category_type_id', $request->sub_category_type_id)
              ->where('status', 1)
              ->paginate(18);
        }
        elseif($request->brand_id && $request->size_id){
          $allData = $this->data
              ->where('brand_id', $request->brand_id)
              ->whereHas('productSize', function($query) {
                  $query->where('size_id', '=', request()->size_id);
              })
              ->where('status', 1)
              ->paginate(18);
        }
        elseif($request->brand_id && $request->color_id){
          $allData = $this->data
              ->where('brand_id', $request->brand_id)
              ->whereHas('productColor', function($query) {
                  $query->where('color_id', '=', request()->color_id);
              })
              ->where('status', 1)
              ->paginate(18);
        }
        elseif($request->sub_category_type_id && $request->size_id){
          $allData = $this->data
              ->Where('sub_category_type_id', $request->s_location)
              ->whereHas('productSize', function($query) {
                  $query->where('size_id', '=', request()->size_id);
              })
              ->where('status', 1)
              ->paginate(18);
        }
        elseif($request->sub_category_type_id && $request->color_id){
          $allData = $this->data
              ->Where('sub_category_type_id', $request->s_location)
              ->whereHas('productColor', function($query) {
                  $query->where('color_id', '=', request()->color_id);
              })
              ->where('status', 1)
              ->paginate(18);
        }
        elseif($request->color_id){
          $allData = $this->data
              ->whereHas('productColor', function($query) {
                  $query->where('color_id', '=', request()->color_id);
              })
              ->where('status', 1)
              ->paginate(18);
        }
        elseif($request->size_id){
          $allData = $this->data
              ->whereHas('productSize', function($query) {
                  $query->where('size_id', '=', request()->size_id);
              })
              ->where('status', 1)
              ->paginate(18);
        }
        elseif($request->sub_category_type_id){
          $allData = $this->data
              ->where('sub_category_type_id', $request->sub_category_type_id)
              ->where('status', 1)
              ->paginate(18);
        }
        elseif($request->brand_id){
          $allData = $this->data
              ->where('brand_id', $request->brand_id)
              ->where('status', 1)
              ->paginate(18);
        }
        else{
          $allData = $this->data->where('status', 1)->paginate(18);
        }



        return view('site.product.index', compact('allData'));


        // dd($request->all());
        // $filterBrandData = $this->brand->where('status', 1)->get();
        // $filterSubCategoryTypeData = $this->productCategoryType->where('status', 1)->get();
        // $filterColorData = $this->color->where('status', 1)->get();
        // $filterSizeData = $this->size->where('status', 1)->get();

        // $allData = $this->data
        //     ->where('status', 1)
        //     ->where('brand_id', $request->brand_id)
        //     ->where('sub_category_type_id', $request->sub_category_type_id)
        //     ->whereHas('productSize', function($query) {
        //            $query->where('id', '=', request()->size_id);
        //        })
        //     ->whereHas('productColor', function($query) {
        //            $query->where('id', '=', request()->color_id);
        //        })
        //     ->where('size_id', $request->size_id)    
        //     ->where('color_id', $request->color_id)
        //     ->paginate(30);

        // $user = $this->data->newQuery();

        // dd( $user );

            // Search for a user based on their name.
            // if ($request->has('brand_id')) {
            //     $user->where('brand_id', $request->input('brand_id'));
            // }

            // Search for a user based on their company.
            // if ($request->has('sub_category_type_id')) {
            //     $user->where('sub_category_type_id', $request->input('sub_category_type_id'));
            // }

            // Search for a user based on their city.
            // if ($request->has('city')) {
            //     $user->where('city', $request->input('city'));
            // }

            // Continue for all of the filters.

            // Get the results and return them.
            // $allData = $user->get();

            // dd( $allData );
    }

    public function ajax_brand($id)
    {
      // $sub_category_types = $this->data->where('brand_id', $id)->pluck("name","id");
      // return json_encode($sub_category_types);
      $sub_category_type_ids = $this->data->where('brand_id', $id)->pluck('sub_category_type_id')->toArray();
      $sub_category_types = $this->productCategoryType->where('status', 1)->whereIn('id', $sub_category_type_ids)->pluck('name', 'id');
      return json_encode($sub_category_types);
    }

    public function ajax_type($id)
    {
      $sub_category_type_ids = $this->data
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
        ->where('sub_category_type_id', $id)
        ->whereNotNull('size_and_symbol')
        ->groupBy('size_and_symbol')
        ->pluck('size_and_symbol','id')
        ->toArray();

      // dd( $measurements );
      // $sub_category_types = $this->size->where('status', 1)->whereIn('id', $sub_category_type_ids)->pluck('name', 'id');

      // $sub_category_types = $this->size->select('id', DB::raw("concat(name, ' - ',measurement_type) as id_name"))
      //                   ->orderBy('name')
      //                   ->pluck('id_name', 'id');
      // dd( $sub_category_types);
      return json_encode($measurements) ;
    }

    public function ajax_size($id)
    {
      $singleProduct = $this->data->where('id', $id)->first();
      $colorIds = $this->data
        ->where('brand_id', $singleProduct->brand_id)
        ->where('sub_category_type_id', $singleProduct->sub_category_type_id)
        ->where('category_id', $singleProduct->category_id)
        ->where('size_and_symbol', $singleProduct->size_and_symbol)
        ->pluck('color_id')
        ->toArray();
      $productColors = $this->color->where('status', 1)->whereIn('id', $colorIds)->pluck('name', 'id');
      return json_encode($productColors);
    }


}