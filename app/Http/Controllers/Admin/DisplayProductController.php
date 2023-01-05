<?php namespace App\Http\Controllers\Admin;

use App\DisplayProduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DisplayProductRequest;
use App\Product;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class DisplayProductController extends Controller {

    public function __construct(DisplayProduct $displayProduct, Product $product)
    {
        $this->module = "product";
        $this->data = $displayProduct;
        $this->product = $product;
        $this->middleware('auth');
    }

    public function index()
    {
        $module = $this->module;
        $singleData = $this->data;
        $allData = $this->data->get();

        $productsData = $this->product->where('status', 1)->pluck('title', 'id');

        $featuredProductsData = $this->data->where('type', 1)->where('store_type', 0)->get();
        $newProductsData = $this->data->where('type', 2)->where('store_type', 0)->get();

        return view('admin.'.$module.'.display_product', compact('allData', 'singleData', 'module', 'productsData', 'featuredProductsData', 'newProductsData'));
    }

    public function post_add(DisplayProductRequest $request)
    {
        $availableProducts = null;
        if($request->products) {
            foreach ($request->products as $product) {
                $availableProducts[] = [
                    'type' => $request->type,
                    'store_type' => 0,
                    'product_id' => $product,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ];
            }
        }

        if($availableProducts) {
            $this->data->insert($availableProducts);
        }

        return redirect($request->id == 'featured' ? 'admin/display-type/featured' : 'admin/display-type/new')->with('success', 'Data has been created.');
    }

    public function get_delete($id)
    {
        $data = $this->data->find($id);
        if($data->image)
            Storage::delete('display-products/'.$data->image);
        $data->delete();
        return redirect()->back()->with('success', 'Your data has been deleted successfully.');
    }

    public function get_products_by_type($id) {
        $featuredProductIds = $this->data
            ->where('type', $id)
            ->where('store_type', 0)
            ->pluck('product_id')
            ->toArray();

        $featuredProductsData = $this->product
            ->where('status', 1)
            ->whereNotIn('id', $featuredProductIds)
            ->pluck('title', 'id');

        return json_encode($featuredProductsData);
    }
}