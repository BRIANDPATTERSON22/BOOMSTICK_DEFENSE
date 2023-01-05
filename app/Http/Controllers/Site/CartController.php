<?php namespace App\Http\Controllers\Site;

use App\Coupon;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Site\CartRequest;
use App\Option;
use App\Product;
use App\RsrProduct;
use App\Shipping;
use Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Response;

class CartController extends Controller
{
    public function __construct(Product $product, Customer $customer, Coupon $coupon, Option $option, Shipping $shipping, RsrProduct $rsrProduct)
    {
        $this->product = $product;
        $this->customer = $customer;
        $this->coupon = $coupon;
        // $this->option = Cache::get('optionCache');
        $this->option = $option;
        $this->shipping = $shipping;
        $this->rsrProduct = $rsrProduct;
        $this->middleware('guest');
    }

    public function get_add($id)
    {
        $option = $this->option->first();

        $user = Auth::user();
        $product = $this->product->find($id);

        if ($user && $user->hasRole('wholesale_customer')) {
            if ($user->customer->discount_percentage) {
                $price = $product->retail_price - (($user->customer->discount_percentage / 100) * $product->retail_price);
            }else{
                $price = $product->retail_price;
            }
        }else{
            $price = $product->discount_percentage ? $product->dicounted_price : $product->sale_price;
        }

        $cart = Cart::instance('cart')->add(
            array(
                'id' => $product->id,
                'name' => $product->title,
                'qty' => 1,
                'price' => $price,
                'options' => array(
                    'slug' => $product->slug,
                    'image' => $product->main_image,
                    'upc' => $product->upc,
                    'qty' => $product->quantity,
                    'retail_price' => $product->retail_price,
                    'sale_price' => $product->sale_price,
                    'dicounted_price' => $product->dicounted_price,
                    'discount_percentage' => $product->discount_percentage,
                    'customer_discount' => $user->customer->discount_percentage ?? NULL,
                    'brand' => $product->brand_id ? $product->brand->name : '--',
                    // 'store_id' => $request->store_id ? $request->store_id : NULL,
                    'store_id' => 0,
                )
            )
        );

        // $cart = Cart::instance('cart')->add(
        //     array(
        //         'id' => $product->id,
        //         'name' => $product->title,
        //         'qty' => 1,
        //         'price' => $product->dicounted_price ? $product->dicounted_price : $product->retail_price,
        //         'options' => array(
        //             'slug' => $product->slug,
        //             'image' => $product->main_image,
        //             'upc' => $product->upc,
        //             'qty' => $product->quantity,
        //             'sale_price' => $product->sale_price,
        //             'dicounted_price' => $product->dicounted_price,
        //             'discount_percentage' => $product->discount_percentage ? $product->discount_percentage : 0,
        //             'brand' => $product->brand_id ? $product->brand->name : '--',
        //         )
        //     )
        // );

        // $cartItems = [
        //   'content' => Cart::content(),
        //   'subtotal' => Cart::subtotal(),
        //   'count' => Cart::content()->count()
        // ];

        // return Response::json($cart);

        // $html = '<div class="dropdown-menu dropdown-menu-right cart-dropdown" id="ajax-show2">';

        //  $html .=' </div>';

        // $contents = view('site.partials.ajax_cart')->render();
        // return $contents;


        // return json_encode($cart);
        // return Response::json(array('cart'=>$cart,'cartItems'=>$cartItems,'contents' => $contents));
        // return response()->json(['success'=>'Data is successfully added']);
        // Session::flash('success','Product added to the cart');
        //   $cart = Cart::instance('cart')->content();
        // return redirect('cart')->with('success', 'The item successfully added to the cart');
        return redirect()->back()->with('success', 'Product has been added to your cart.');
    }


    public function post_add($id, CartRequest $request)
    {
        $option = $this->option->first();
        
        // $product = $this->product->find($id);
        $product = $this->product->where('slug', $id)->first();
        $rsrProduct = $this->rsrProduct->where('rsr_stock_number', $id)->first();

        if (!$product && !$rsrProduct) {
            abort(404);
        }

        if ($product){
            $type = 0;
            // $singleProduct = $this->product->find($id);
            $singleProduct = $this->product->where('slug', $id)->first();
            $mainCategory = $singleProduct->rel_main_category ? $singleProduct->rel_main_category->name : NULL;
            $subCategory = $singleProduct->sub_category ? $singleProduct->sub_category->name : NULL;
            $isFireArm = $singleProduct->sub_category ? $singleProduct->sub_category->is_firearm : NULL;
            $isAgeVerificatioRequired = $singleProduct->sub_category ? $singleProduct->sub_category->is_age_verification_required : NULL;
            $price = $singleProduct->retail_price;
        }else{
            $type = 1;
            $singleProduct = $this->rsrProduct->where('rsr_stock_number', $id)->first();
            $mainCategory = $singleProduct->rsr_category ? $singleProduct->rsr_category->department_name : NULL;
            $subCategory = NULL;
            $isFireArm = $singleProduct->blocked_from_dropship == "Y" ? 1 : NULL;
            $isAgeVerificatioRequired = $singleProduct->adult_signature_required == "Y" ? 1 : NULL;
            $price = $singleProduct->get_rsr_retail_price();
            $rsrImage = $singleProduct->src_rsr_hr_image();
        }

        $cart = Cart::instance('cart')->add(
            array(
                'id' => $type == 0 ? $singleProduct->slug : $singleProduct->rsr_stock_number,
                // 'id' => $type == 0 ? $singleProduct->id : $singleProduct->rsr_stock_number,
                'name' => $type == 0 ? $singleProduct->title : $singleProduct->product_description,
                'qty' => $request->qty ? $request->qty : 1,
                'price' => $price,
                'options' => array(
                    // 'p_id' => $type,
                    'type' => $type,
                    'department_number' => $type == 0 ? $singleProduct->rel_main_category ? $singleProduct->rel_main_category->name : '--' : $singleProduct->department_number,
                    'slug' => $type == 0 ? $singleProduct->slug : $singleProduct->rsr_stock_number,
                    'image' => $type == 0 ? $singleProduct->main_image : $rsrImage,
                    'upc' => $type == 0 ? $singleProduct->upc : $singleProduct->upc_code,
                    'qty' => $type == 0 ? $singleProduct->quantity : $singleProduct->inventory_quantity,
                    'retail_price' => $singleProduct->retail_price,
                    'brand' => $type == 0 ? $singleProduct->brand ? $singleProduct->brand->name : '--' : $singleProduct->full_manufacturer_name,

                    // 'weight' => $type == 0 ? $singleProduct->weight : $singleProduct->product_weight,
                    // 'width' => $type == 0 ? $singleProduct->width : $singleProduct->shipping_width,
                    // 'length' => $type == 0 ? $singleProduct->length : $singleProduct->shipping_length,
                    // 'height' => $type == 0 ? $singleProduct->height : $singleProduct->shipping_height,
                    'weight' => $type == 0 ? $singleProduct->weight ?? 1 : $singleProduct->product_weight ?? 1,
                    'width' => $type == 0 ? $singleProduct->width ?? 1 : $singleProduct->shipping_width ?? 1,
                    'length' => $type == 0 ? $singleProduct->length ?? 1 : $singleProduct->shipping_length ?? 1,
                    'height' => $type == 0 ? $singleProduct->height ?? 1 : $singleProduct->shipping_height ?? 1,

                    // 'is_firearm' => 0,
                    // 'discount_percentage' => $product->discount_percentage,
                    // 'main_category' => $type == 0 ? $singleProduct->slug : $singleProduct->rsr_stock_number,
                    // 'sub_category' => $type == 0 ? $singleProduct->slug : $singleProduct->rsr_stock_number,
                    // 'is_firearm' => $type == 0 ? $singleProduct->slug : $singleProduct->rsr_stock_number,
                    // 'is_age_verification_required' => $type == 0 ? $singleProduct->slug : $singleProduct->rsr_stock_number,
                    // 'is_adult_signature_required' => $type == 0 ? $singleProduct->sub_category ? $singleProduct->sub_category->is_age_verification_required : "--" : $singleProduct->adult_signature_required,
                    // 'is_firearm' => $type == 0 ? $singleProduct->slug : $singleProduct->rsr_stock_number,
                    // 'main_category' => $type == 0 ? $singleProduct->rel_main_category ? $singleProduct->rel_main_category->name : "--" : $singleProduct->rsr_category ? $singleProduct->rsr_category->department_name : "--",
                    // 'sub_category' => $type == 0 ? $singleProduct->sub_category ? $singleProduct->sub_category->name : "--" : "No SubCategory",

                    'main_category' => $mainCategory,
                    'sub_category' => $subCategory,
                    'is_firearm' => $isFireArm,
                    'is_age_verification_required' => $isAgeVerificatioRequired,
                    // 'available_states' => $availableStates,
                )
            )
        );

        return redirect()->back()->with('success', 'Product has been added to your cart.');
    }

    public function post_update(Request $request, $cart_id)
    {
        Cart::instance('cart')->update($cart_id, array('qty' => $request->qty));

        // return redirect('cart')->with('success', 'The cart item successfully updated');
        return redirect()->back()->with('success', 'Your basket has been updated.');
    }

    public function get_remove($cart_id)
    {
        // Cart::instance('cart')->remove($cart_id);

        // return redirect()->back()->with('success', 'The product has been removed.');
        // return redirect('cart')->with('success', 'The product has been removed.');
        
        Cart::instance('cart')->remove($cart_id);
        if (Cart::content()->count() == 0) {
            return redirect('cart')->with('success', 'The product has been removed.');
        }else{
            return redirect()->back()->with('success', 'The product has been removed.');
        }
    }

    public function get_remove_all()
    {
        Cart::instance('cart')->destroy();

        return redirect('cart')->with('success', 'All products has been removed.');
    }

    public function get_cart()
    {
        if (Cart::instance('cart')->count() == 0) {
            return redirect('products')->with('error', 'Your Cart is empty. Add some products to the cart.');
        }

        // Cart Data
        $cartItems = Cart::instance('cart')->content();

        // Available shipping Data
        $shippingData = $this->shipping->where('status', 1)->get();

        if (Auth::check()) {
            $user_id = Auth::id();
            $customer = $this->customer->where('user_id', $user_id)->first();
        } else {
            $customer = null;
        }

        $coupons = $this->coupon->where('status', 1)->get();
        $coupon_code = Session::get('coupon');
        // dd($coupon_code);
        $shipping = null;

        $random_api = substr(md5(rand()), 0, 10);
        Session::put('random_api', $random_api);

        $otherProducts = $this->product->where('status', 1)->inRandomOrder()->limit(8)->get();

        return view('site.cart.cart', compact('cartItems', 'coupon_code', 'customer', 'otherProducts', 'coupons', 'shippingData'));
    }

    // Cart Coupon Update Function
    public function post_coupon(Request $request)
    {
        $todayDate = new \DateTime('now');
        $checkin = session('checkinSession');

        $coupon = $this->coupon->where('series_no', $request->series_no)
//            ->where('start_date', '<=', $checkin)
//            ->where('expiry_date', '>=', $checkin)
            ->where('status', 1)
            ->first();

        if ($coupon && $coupon->use_count < $coupon->count) {
            Session::put('coupon', $coupon);
            // return redirect('cart')->with('success', 'Coupon code has been updated');
            return redirect()->back()->with('success', 'Coupon code has been updated');
        } else {
            if (!$request->series_no) {
                // return redirect('cart')->with('error', 'Enter the coupon code!');
                return redirect()->back()->with('error', 'Enter the coupon code!');
            }
            // return redirect('cart')->with('error', 'Invalid coupon code!');
            return redirect()->back()->with('error', 'Invalid coupon code!');
        }
    }

    public function remove_coupon()
    {
        Session::forget('coupon');
        return redirect()->back()->with('success', 'The coupon code has been removed.');
    }
}