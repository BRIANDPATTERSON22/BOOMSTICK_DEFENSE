<?php namespace App\Http\Controllers\Site;

use Auth;
use App\Product;
use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class WishController extends Controller
{
    public function __construct(Product $product, Customer $customer)
    {
        $this->product = $product;
        $this->customer = $customer;
        $this->middleware('guest');
    }

    public function get_add($id)
    {
        $product = $this->product->find($id);
        Cart::instance('wish')->add(
            array(
                'id' => $product->id,
                'qty' => 1,
                'name' => $product->name,
                'price' => $product->special_price != 0 ? $product->special_price : $product->price,
                'options' => array(
                    'slug' => $product->slug,
                    'image' => $product->main_image,
                    'description' => $product->description,
                )
            )
        );

        return redirect()->back()->with('success', 'The item successfully added to wish list');
    }

    public function post_update(Request $request, $cart_id)
    {
        Cart::instance('wish')->update($cart_id, array('qty' => $request->qty));

        return redirect('wishlist')->with('success', 'The cart item successfully updated');
    }

    public function get_remove($cart_id)
    {
        Cart::instance('wish')->remove($cart_id);

        return redirect('wishlist')->with('success', 'The cart item successfully removed');
    }

    public function get_remove_all()
    {
        Cart::instance('wish')->destroy();

        return redirect('wishlist')->with('success', 'All cart items successfully removed');
    }

    public function get_wishlist()
    {
        $wishItems = Cart::instance('wish')->content();

        if(Auth::check()) {
            $user_id = Auth::id();
            $customer = $this->customer->where('user_id', $user_id)->first();
        }else{
            $customer = null;
        }

        $otherProducts = $this->product->where('status', 1)->inRandomOrder()->limit(8)->get();

        return view('site.cart.wishlist', compact('wishItems', 'customer', 'otherProducts'));
    }
}