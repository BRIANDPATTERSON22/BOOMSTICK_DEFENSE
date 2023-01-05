<?php namespace App\Http\Controllers\Site;
use Auth;
use App\Product;
use App\ProductCategory;
use App\ProductPhoto;
use App\Http\Controllers\Controller;
use App\WishList;
use App\Customer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class WishListController extends Controller
{
    public function __construct(ProductCategory $category, Product $product, ProductPhoto $photo,WishList $wishList, Customer $customer)
    {
        $this->module = "customer";
        $this->data = $product;
        $this->category = $category;
        $this->photo = $photo;
        $this->customer = $customer;
        $this->wishList = $wishList;
        $this->middleware('guest');
    }

    public function get_add($pid)
    {
        $user_id = Auth::id();
        $customer = $this->customer->where('user_id', $user_id)->first();
        $exist = $this->wishList->where('customer_id', $customer->id)->where('product_id', $pid)->first();

        if(!$exist){
            $this->wishList->customer_id = $customer->id;
            $this->wishList->product_id = $pid;
            $this->wishList->user_id = $user_id;
            $this->wishList->save();
        }
        return redirect()->back()->with('success', 'Product has been added to your wishlist.');
    }

    public function get_remove($pid)
    {
        $user_id = Auth::id();
        $customer = $this->customer->where('user_id', $user_id)->first();
        $this->wishList->where('customer_id', $customer->id)->where('product_id', $pid)->forceDelete();

        return redirect()->back()->with('success', 'Product has been removed from your wishlist.');
    }

    // public function get_wish_list()
    // {
    //     $module = $this->module;
    //     $user_id = Auth::id();
    //     $customer = $this->customer->where('user_id', $user_id)->first();
    //     $allData = $this->wishList->where('customer',$customer->id)->get();

    //     return view('site.'.$module.'.wishlist', compact('allData','module'));
    // }

    public function force_delete_all()
    {
        $user_id = Auth::id();
        $customer = $this->customer->where('user_id', $user_id)->first();
        $allData = $this->wishList
            ->where('customer_id',$customer->id)
            ->pluck('id')
            ->toArray();
        $this->wishList->whereIn('id',$allData)->forceDelete(); 
        return redirect('my-wish-lists')->with('success', 'Your data has been deleted successfully.');
    }

   public function force_delete($id)
    {
        $singleData = $this->wishList->find($id);
        $singleData->forceDelete();
        return redirect('my-wish-lists')->with('success', 'Your data has been deleted successfully.');
    }

    
}