<?php namespace App\Http\Controllers\Admin;

use App\DisplayProduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DisplayProductRequest;
use App\RsrProduct;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class DisplayRsrProductController extends Controller {

    public function __construct(DisplayProduct $displayProduct, RsrProduct $rsrProduct)
    {
        $this->module = "rsr-product";
        $this->data = $displayProduct;
        $this->rsrProduct = $rsrProduct;
        $this->middleware('auth');
    }

    public function index()
    {
        $module = $this->module;
        $singleData = $this->data;
        $allData = $this->data->get();

        // Type 1 - fatured,  2 - new products
        // Store Type 0 - Boomstick,  1 - RSR
        // RSR
        $rsrProductsData = $this->rsrProduct
                ->whereHas('rsr_category', function($query) {
                    $query->where('status', 1);
                })
                ->orderBy('product_description','ASC')
                ->limit(3000)
                ->pluck('product_description', 'rsr_stock_number');

        $rsrFeaturedProductsData = $this->data->where('type', 1)->where('store_type', 1)->get();
        $rsrNewProductsData = $this->data->where('type', 2)->where('store_type', 1)->get();

        return view('admin.'.$module.'.display_product', compact('allData', 'singleData', 'module', 'rsrProductsData', 'rsrFeaturedProductsData', 'rsrNewProductsData'));
    }

    public function post_add(DisplayProductRequest $request)
    {
        $availableProducts = null;
        if($request->products) {
            foreach ($request->products as $product) {
                $availableProducts[] = [
                    'type' => $request->type,
                    'store_type' => 1,
                    'product_id' => $product,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ];
            }
        }

        if($availableProducts) {
            $this->data->insert($availableProducts);
        }

        return redirect($request->id == 'featured' ? 'admin/rsr-display-type/featured' : 'admin/rsr-display-type/new')->with('success', 'Data has been created.');
    }

    public function get_delete($id)
    {
        $data = $this->data->find($id);

        if(!$data){
            return redirect()->back()->with('error', 'Product has not been permanently removed.');
        }

        $data->delete();
        return redirect()->back()->with('success', 'Product has been removed successfully.');
    }

    public function get_products_by_type($id) {
        $displayedProducttIds = $this->data
            ->where('type', $id)
            ->where('store_type', 1)
            ->pluck('product_id')
            ->toArray();

        $rsrProductsData = $this->rsrProduct
            ->whereNotIn('id', $displayedProducttIds)
            ->limit(2000)
            ->pluck('product_description', 'rsr_stock_number');

        return json_encode($rsrProductsData);
    }
}