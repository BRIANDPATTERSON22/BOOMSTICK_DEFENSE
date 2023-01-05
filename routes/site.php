<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['auth', 'role:customer']], function () {
    // 
    Route::get('checkout-age-verification', 'Site\OrderController@get_guest_checkout_verification');
    Route::post('checkout-age-verification', 'Site\OrderController@post_guest_checkout_verification');
    Route::get('checkout-remove-products', 'Site\OrderController@get_guest_checkout_remove_products');
    Route::get('checkout-state-verification', 'Site\OrderController@get_guest_checkout_state_verification');
    Route::post('checkout-state-verification', 'Site\OrderController@post_guest_checkout_state_verification');
    Route::get('checkout-remove-state-products', 'Site\OrderController@get_guest_checkout_remove_state_products');
    Route::get('checkout-ffl-dealers', 'Site\OrderController@get_guest_ffl_dealer');
    Route::post('checkout-ffl-dealers', 'Site\OrderController@post_guest_ffl_dealer');

    //Checkout
    Route::get('checkout-address', 'Site\OrderController@get_checkout_address');
    Route::post('checkout-address', 'Site\OrderController@post_checkout_address');
    Route::get('checkout-shipping', 'Site\OrderController@get_checkout_shipping');
    Route::post('checkout-shipping', 'Site\OrderController@post_checkout_shipping');
    Route::get('checkout-payment', 'Site\OrderController@get_checkout_payment');
    Route::post('checkout-payment', 'Site\OrderController@post_checkout_payment');
    Route::get('checkout-review', 'Site\OrderController@get_checkout_review');
    Route::post('checkout-review', 'Site\OrderController@post_checkout_review');
    Route::get('paypal', 'Site\OrderController@get_paypal');
    Route::post('status', 'Site\OrderController@post_paypal_status');
    Route::get('completed', 'Site\OrderController@get_payment_completed');
    Route::get('cancelled', 'Site\OrderController@get_payment_cancelled');
    // Authorize net payment method
    Route::get('pay-by-authorize-net', 'Site\OrderController@get_autherize_net');
    Route::post('pay-by-authorize-net', 'Site\OrderController@post_authorize_net');

    Route::get('change-password', 'Site\CustomerController@get_change_password');
    Route::post('change-password', 'Site\CustomerController@post_change_password');
    Route::get('my-account', 'Site\CustomerController@get_my_account');
    Route::post('my-account', 'Site\CustomerController@post_my_account');
    Route::get('my-orders', 'Site\CustomerController@get_my_orders');
    Route::get('my-wishlist', 'Site\CustomerController@get_my_wishlist');
    Route::get('post-my-image', 'Site\CustomerController@post_my_image');
    Route::post('post-my-image', 'Site\CustomerController@post_my_image');
    Route::get('image-delete/{id}', 'Site\CustomerController@image_delete');
    Route::get('profile-image-delete/{id}', 'Site\CustomerController@profile_image_delete');
});


Route::group(['middleware' => 'web'], function () {
    // 
    Route::get('/', 'Site\HomeController@index');

    //Auth
    Route::get('login', 'Site\AuthController@get_login');
    Route::post('login', 'Site\AuthController@post_login');
    Route::get('logout', 'Site\AuthController@get_logout');

    Route::get('register', 'Site\AuthController@get_register');
    Route::post('register', 'Site\AuthController@post_register');
    Route::get('email-verification/{token}', 'Site\AuthController@get_validate');
    Route::get('forgot-password', 'Site\AuthController@get_forgot_password');
    Route::post('forgot-password', 'Site\AuthController@post_forgot_password');
    Route::get('forgot-password/{hash}', 'Site\AuthController@get_forgot_reset');
    Route::post('forgot-password/{hash}', 'Site\AuthController@post_forgot_reset');

    // Shopping Cart
    Route::get('cart', 'Site\CartController@get_cart');
    // Route::get('{id}/item', 'Site\CartController@get_add');
    Route::post('{id}/item', 'Site\CartController@post_add');
    Route::post('item/{cart_id}/update', 'Site\CartController@post_update');
    Route::get('item/{cart_id}/remove', 'Site\CartController@get_remove');
    Route::get('cart-remove-all', 'Site\CartController@get_remove_all');
    Route::post('cart/post-coupon', 'Site\CartController@post_coupon');
    Route::get('cart/remove-coupon', 'Site\CartController@remove_coupon');
    Route::get('checkout-review/remove-coupon', 'Site\CartController@remove_coupon');

    // Products
    Route::get('products', 'Site\ProductController@get_products');
    Route::get('product/{slug}', 'Site\ProductController@get_single_product');
    Route::get('products-sort/{sort}', 'Site\ProductController@get_sort');
    Route::get('product/{category}', 'Site\ProductController@get_category');
    Route::get('product/{category}/{id}', 'Site\ProductController@get_single');
    Route::get('catalog/{id}', 'Site\ProductController@get_product_catalog');
    Route::post('search', 'Site\ProductController@post_search');
    // Route::get('search', 'Site\ProductController@get_products');
    Route::get('search/p-{searchText}', 'Site\ProductController@get_search_product');
    Route::get('get-ajax-products', 'Site\ProductController@get_ajax_products');
    Route::get('searched-products', 'Site\ProductController@searched_products')->name('searched-products');

    // RSR Home Page
    // Route::get('rsr-products', 'Site\RsrProductController@index_rsr');
    // Route::get('rsr-products/{slug}', 'Site\RsrProductController@get_single_product');
    // Route::get('department/{id}', 'Site\RsrProductController@get_products_by_department');

    // Get products by categories
    Route::get('main-categories', 'Site\ProductController@get_main_categories');
    Route::get('main-categories/{slug}', 'Site\ProductController@get_products_by_main_category');

    // Get products by sub categories
    Route::get('sub-categories', 'Site\ProductController@get_sub_categories');
    Route::get('sub-categories/{slug}', 'Site\ProductController@get_products_by_sub_category');

    // Get products by brands or manufactures
    Route::get('brands', 'Site\ProductController@get_brands');
    Route::get('brands/{slug}', 'Site\ProductController@get_products_by_brand');

    // Get products by manufactures
    Route::get('manufacturers', 'Site\ProductController@get_manufacturers');
    Route::get('manufacturers/{slug}', 'Site\ProductController@get_products_by_manufacturer');
    
    // Single Page Checkout
    // Route::post('address', 'Site\CheckoutController@post_address');
    // Route::post('shipping', 'Site\CheckoutController@post_shipping');
    // Route::post('payment', 'Site\CheckoutController@post_payment');
    // Route::get('checkout', 'Site\CheckoutController@get_checkout');
    // Route::post('checkout', 'Site\CheckoutController@post_checkout');
    // Route::get('payment', 'Site\CheckoutController@payment');
    // Route::post('paypal-status', 'Site\CheckoutController@post_paypal_status');
    // Route::get('order-completed', 'Site\CheckoutController@get_order_completed');
    // Route::get('order-cancelled', 'Site\CheckoutController@get_order_cancelled');

    // Guest Checkout
    Route::get('verification', 'Site\GuestCheckoutController@get_guest_checkout_verification');
    Route::post('verification', 'Site\GuestCheckoutController@post_guest_checkout_verification');
    Route::get('remove-products', 'Site\GuestCheckoutController@get_guest_checkout_remove_products');
    Route::get('state-verification', 'Site\GuestCheckoutController@get_guest_checkout_state_verification');
    Route::post('state-verification', 'Site\GuestCheckoutController@post_guest_checkout_state_verification');
    Route::get('remove-state-products', 'Site\GuestCheckoutController@get_guest_checkout_remove_state_products');
    Route::get('ffl-dealers', 'Site\GuestCheckoutController@get_guest_ffl_dealer');
    Route::post('ffl-dealers', 'Site\GuestCheckoutController@post_guest_ffl_dealer');
    
    Route::get('address', 'Site\GuestCheckoutController@get_guest_checkout_address');
    Route::post('address', 'Site\GuestCheckoutController@post_guest_checkout_address');
    Route::get('shipping-methods', 'Site\GuestCheckoutController@get_guest_checkout_shipping');
    Route::post('shipping-methods', 'Site\GuestCheckoutController@post_guest_checkout_shipping');
    Route::get('payment-methods', 'Site\GuestCheckoutController@get_guest_checkout_payment');
    Route::post('payment-methods', 'Site\GuestCheckoutController@post_guest_checkout_payment');
    Route::get('order-review', 'Site\GuestCheckoutController@get_guest_checkout_order_review');
    Route::post('order-review', 'Site\GuestCheckoutController@post_guest_checkout_order_review');

    // Payment Status
    Route::get('pay-by-paypal', 'Site\GuestCheckoutController@payment');
    Route::post('paypal-status', 'Site\GuestCheckoutController@post_paypal_status');
    Route::get('order-completed', 'Site\GuestCheckoutController@get_order_completed');
    Route::get('order-cancelled', 'Site\GuestCheckoutController@get_order_cancelled');

    // Authorize net payment method
    Route::get('pay-by-authorize-net', 'Site\GuestCheckoutController@get_authorize_net');
    // Route::post('pay-by-authorize-net', 'Site\GuestCheckoutController@post_authorize_net');
    Route::get('authorize-net-payment-status', 'Site\GuestCheckoutController@get_authorize_net_payment_status');
    Route::get('authorize-net-token', 'Site\GuestCheckoutController@getAnAcceptPaymentPage');
    Route::get('authorize-net-payment', 'Site\GuestCheckoutController@createAnAcceptPaymentTransaction');

    // Back In Stock
    Route::post('product-notification/{pid}', 'Site\SubscribeController@post_product_notification');

    //Review
    Route::post('review/{pid}', 'Site\ReviewController@post_review');

    //Subscribe
    Route::post('subscribe', 'Site\SubscribeController@post_subscribe');

    //Blog
    Route::get('blog', 'Site\BlogController@get_all');
    Route::get('blog/{category}', 'Site\BlogController@get_category');
    Route::get('blog/{category}/{id}', 'Site\BlogController@get_single');

    //Contact
    Route::get('contact-us', 'Site\ContactController@get_contact');
    Route::post('contact-us', 'Site\ContactController@post_contact');

    Route::get('get-ups-rating', 'Site\CheckoutController@get_ups_rating');
    Route::get('get-fedex-rating', 'Site\CheckoutController@get_fedex_rating');
    // Route::get('get-address-validate', 'Site\CheckoutController@get_address_validate');
    // Route::get('unishippers-get-rating', 'Site\CheckoutController@unishippers_get_rating');

    // Route::get('category-attributes', function(){
    //     foreach (App\RsrMainCategory::get() as $row) {
    //         DB::table('rsr_main_category_attributes')->insert([
    //             'department_id' => $row->department_id,
    //             'category_id' => $row->category_id,
    //             'status' => $row->status,
    //             'created_at' => new DateTime,
    //             'updated_at' => new DateTime,
    //         ]);
    //     }
    // });
    
    // FFL Dealer
    Route::get('get-ffl-dealers', 'Site\RsrApiController@get_ffl_dealers_json');

    //Page
    Route::get('{slug}', 'Site\StaticPageController@get_single');
});
