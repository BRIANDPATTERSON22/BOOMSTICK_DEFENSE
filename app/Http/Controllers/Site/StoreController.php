<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Site\StoreRequest;
use App\Page;
use App\Product;
use App\Store;
use App\StoreProduct;
use Illuminate\Support\Facades\Session;

class StoreController extends Controller
{
    public function __construct(Store $store, StoreProduct $storeProduct, Product $product)
    {
        $this->module = "store";
        $this->data = $store;
        $this->storeProduct = $storeProduct;
        $this->product = $product;
        $this->middleware('guest');
    }

    public function index()
    {
        $module = $this->module;
        // Session::forget('searchText');

        $allData = [];
        return view('site.'.$module.'.index', compact('module', 'allData'));
    }

    public function post_search_text(StoreRequest $request)
    {
        // Session::forget('searchText');
        Session::forget('storesByProduct_Session');

        $searchText = $request->search_text;

        if($searchText){
            return redirect('store-locator/'.$searchText);
        }else{
            return redirect('store-locator')->with('success', 'Products Not Found!');
        }
    }

    public function get_search_result($searchText)
    {
        $module = $this->module;
        Session::put('searchText', $searchText);

        $allData = $this->data
            ->where('status', 1)
            ->where('division', 'like', '%' .$searchText. '%')
            ->orWhere('zip', 'like', '%' .$searchText. '%')
            ->orWhere('city', 'like', '%' .$searchText. '%')
            ->orWhere('state', 'like', '%' .$searchText. '%')
            ->paginate(20);

        if(count($allData)>0) {
            return view('site.'.$module.'.index', compact('allData'));
        }else{
            return redirect('store-locator')->with('error', 'No data found for your search keyword: '.$searchText);
        }
    }

    public function get_category($category)
    {
        $module = $this->module;
        $cat_data = $this->category->where('slug', $category)->where('status', 1)->first();

        if(isset($cat_data)){
            $cat_id = $cat_data->id;
            $allData = $this->data->where('category_id', $cat_id)->where('status', 1)->orderBy('id', 'DESC')->paginate(20);

            if(count($allData)>0) {
                return view('site.'.$module.'.index', compact('allData'));
            }
            else{
                return redirect($module.'s')->with('error', 'No Data Found for '. $category);
            }
        }
        else{
            return view('site.errors.404');
        }
    }

    public function get_single($category, $id)
    {
        $module = $this->module;

        $singleData = $this->data->find($id);
        $otherData = $this->data->where('id', '!=', $id)->where('status', 1)->orderBy('id', 'DESC')->limit(5)->get();

        return view('site.'.$module.'.single',compact('singleData', 'otherData'));
    }

    public function get_stores_by_product($slug)
    {
        Session::forget('searchText');

        $module = $this->module;
        $singleData = $this->product->where('slug', $slug)->first();

        if ($singleData) {
            Session::put('storesByProduct_Session', $singleData->title);

            $availableStores = $this->storeProduct
                ->where('product_id', $singleData->id)
                ->pluck('store_id')
                ->toArray();

            $allData = $this->data->where('status', 1)->whereIn('store_id', $availableStores)->paginate(20);

            return view('site.'.$module.'.index', compact('allData'));
        }else{
             return view('site.errors.404');            
        }
    }
}