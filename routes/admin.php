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

Route::group(['prefix' => 'admin', 'middleware' =>  ['auth', 'role:super-admin|admin|manager']], function () {

    //Role
    Route::get('roles', 'Admin\RoleController@index');
    Route::post('roles', 'Admin\RoleController@post_add');
    Route::get('role/{id}/edit', 'Admin\RoleController@index');
    Route::post('role/{id}/edit', 'Admin\RoleController@post_edit');
    Route::get('role/{id}/delete', 'Admin\RoleController@get_delete');

    //User
    Route::get('users', 'Admin\UserController@index');
    Route::post('users', 'Admin\UserController@post_add');
    Route::get('user/{id}/edit', 'Admin\UserController@index');
    Route::post('user/{id}/edit', 'Admin\UserController@post_edit');
    Route::get('user/{id}/delete', 'Admin\UserController@get_delete');
    Route::post('user/{id}/password', 'Admin\UserController@post_password');
    Route::get('users/{id}/profile-image-delete', 'Admin\UserController@user_profile_image_delete');

    //Permission
    Route::get('permissions', 'Admin\PermissionController@index');
    Route::post('permissions', 'Admin\PermissionController@post_add');
    Route::get('permission/{id}/edit', 'Admin\PermissionController@index');
    Route::post('permission/{id}/edit', 'Admin\PermissionController@post_edit');
    Route::get('permission/{id}/delete', 'Admin\PermissionController@get_delete');

    //Menu
    Route::get('menus', 'Admin\MenuController@index');
    Route::post('menus', 'Admin\MenuController@post_add');
    Route::get('menu/{id}/edit', 'Admin\MenuController@index');
    Route::post('menu/{id}/edit', 'Admin\MenuController@post_edit');
    Route::get('menu/{id}/delete', 'Admin\MenuController@get_delete');
    Route::get('menu-sub/{id}/delete', 'Admin\MenuController@get_delete_sub');

    //Pages
    Route::get('pages', 'Admin\PageController@get_index');
    Route::get('page/add', 'Admin\PageController@get_add');
    Route::post('page/add', 'Admin\PageController@post_add');
    Route::get('page/{id}/edit', 'Admin\PageController@get_edit');
    Route::post('page/{id}/edit', 'Admin\PageController@post_edit');
    Route::get('page/{id}/view', 'Admin\PageController@get_view');
    Route::get('pages/trash', 'Admin\PageController@get_trash');
    Route::get('page/{id}/soft-delete', 'Admin\PageController@soft_delete');
    Route::get('page/{id}/restore', 'Admin\PageController@get_restore');
    Route::get('page/{id}/force-delete', 'Admin\PageController@force_delete');
    Route::get('page/{id}/image-delete', 'Admin\PageController@image_delete');

    //Contact enquiry
    Route::get('contacts', 'Admin\ContactController@index');
    Route::get('contact/{id}/view', 'Admin\ContactController@get_view');
    Route::get('contacts/trash', 'Admin\ContactController@get_trash');
    Route::get('contact/{id}/soft-delete', 'Admin\ContactController@soft_delete');
    Route::get('contact/{id}/restore', 'Admin\ContactController@get_restore');
    Route::get('contact/{id}/force-delete', 'Admin\ContactController@force_delete');

    //Slider
    Route::get('sliders', 'Admin\SliderController@get_edit');
    Route::post('sliders', 'Admin\SliderController@post_edit');
    Route::get('sliders/photo/{id}/delete', 'Admin\SliderController@photo_delete');
    Route::post('sliders/photo/{id}/update', 'Admin\SliderController@photo_update');
    Route::get('sliders/data/{data}/{id}/delete', 'Admin\SliderController@data_delete');

    //Options
    Route::get('options', 'Admin\OptionController@get_edit');
    Route::post('options', 'Admin\OptionController@post_edit');
    Route::get('options/delete-favicon', 'Admin\OptionController@delete_favicon');
    Route::get('options/delete-logo', 'Admin\OptionController@delete_logo');
    Route::get('product-settings', 'Admin\OptionController@get_setting');
    Route::post('product-settings', 'Admin\OptionController@post_setting');

    Route::get('cache/flush', 'Admin\HomeController@cache_flush');
    Route::get('maintenance/down', 'Admin\HomeController@maintenance_down');
    Route::get('maintenance/up', 'Admin\HomeController@maintenance_up');
    Route::get('artisan/{com}', 'Admin\HomeController@run_artisan');

    Route::get('sortable-order', 'Admin\OptionController@get_order');

    //Blocks
    Route::get('blocks', 'Admin\BlockController@get_index');
    Route::get('block/add', 'Admin\BlockController@get_add');
    Route::post('block/add', 'Admin\BlockController@post_add');
    Route::get('block/{id}/edit', 'Admin\BlockController@get_edit');
    Route::post('block/{id}/edit', 'Admin\BlockController@post_edit');
    Route::get('block/{id}/delete', 'Admin\BlockController@get_delete');
    Route::get('block/{id}/image-delete', 'Admin\BlockController@image_delete');

    Route::get('media', 'Admin\BlockController@get_media');
    Route::get('media/archive/{year}', 'Admin\BlockController@get_media_archive');
    Route::post('media', 'Admin\BlockController@post_media');
    Route::get('media/{id}/delete', 'Admin\BlockController@get_media_delete');

    //Event
    Route::get('events', 'Admin\EventController@get_index');
    Route::get('events/trash', 'Admin\EventController@get_trash');
    Route::get('events/archive/{year}', 'Admin\EventController@get_archive');

    Route::get('event/add', 'Admin\EventController@get_add');
    Route::post('event/add', 'Admin\EventController@post_add');
    Route::get('event/{id}/edit', 'Admin\EventController@get_edit');
    Route::post('event/{id}/edit', 'Admin\EventController@post_edit');
    Route::get('event/{id}/delete', 'Admin\EventController@get_delete');
    Route::get('event/{id}/view', 'Admin\EventController@get_view');
    Route::get('event/{id}/soft-delete', 'Admin\EventController@soft_delete');
    Route::get('event/{id}/restore', 'Admin\EventController@get_restore');
    Route::get('event/{id}/force-delete', 'Admin\EventController@force_delete');
    Route::get('event/{id}/image-delete', 'Admin\EventController@image_delete');

    #Advertisment
    Route::get('advertisements', 'Admin\AdvertisementController@index');
    Route::get('advertisement/add', 'Admin\AdvertisementController@get_add');
    Route::post('advertisement/add', 'Admin\AdvertisementController@post_add');
    Route::get('advertisement/{id}/edit', 'Admin\AdvertisementController@get_edit');
    Route::post('advertisement/{id}/edit', 'Admin\AdvertisementController@post_edit');
    Route::get('advertisement/{id}/view', 'Admin\AdvertisementController@get_view');
    Route::get('advertisements/trash', 'Admin\AdvertisementController@get_trash');
    Route::get('advertisement/{id}/soft-delete', 'Admin\AdvertisementController@soft_delete');
    Route::get('advertisement/{id}/restore', 'Admin\AdvertisementController@get_restore');
    Route::get('advertisement/{id}/force-delete', 'Admin\AdvertisementController@force_delete');

    //Photo
    Route::get('photos', 'Admin\PhotoController@get_index');
    Route::get('photos/trash', 'Admin\PhotoController@get_trash');
    Route::get('photos/archive/{year}', 'Admin\PhotoController@get_archive');

    Route::get('photo/add', 'Admin\PhotoController@get_add');
    Route::post('photo/add', 'Admin\PhotoController@post_add');
    Route::get('photo/{id}/edit', 'Admin\PhotoController@get_edit');
    Route::post('photo/{id}/edit', 'Admin\PhotoController@post_edit');
    Route::get('photo/{id}/view', 'Admin\PhotoController@get_view');
    Route::get('photos/photo/{id}/delete', 'Admin\PhotoController@photo_delete');
    Route::post('photos/photo/{id}/update', 'Admin\PhotoController@photo_update');
    Route::get('photo/{id}/soft-delete', 'Admin\PhotoController@soft_delete');
    Route::get('photo/{id}/restore', 'Admin\PhotoController@get_restore');
    Route::get('photo/{id}/force-delete', 'Admin\PhotoController@force_delete');

    //Video
    Route::get('videos', 'Admin\VideoController@get_index');
    Route::get('videos/trash', 'Admin\VideoController@get_trash');
    Route::get('videos/archive/{year}', 'Admin\VideoController@get_archive');

    Route::get('video/add', 'Admin\VideoController@get_add');
    Route::post('video/add', 'Admin\VideoController@post_add');
    Route::get('video/{id}/edit', 'Admin\VideoController@get_edit');
    Route::post('video/{id}/edit', 'Admin\VideoController@post_edit');
    Route::get('video/{id}/delete', 'Admin\VideoController@get_delete');
    Route::get('video/{id}/view', 'Admin\VideoController@get_view');
    Route::get('video/{id}/soft-delete', 'Admin\VideoController@soft_delete');
    Route::get('video/{id}/restore', 'Admin\VideoController@get_restore');
    Route::get('video/{id}/force-delete', 'Admin\VideoController@force_delete');

    //Video album
    Route::get('videos/album', 'Admin\VideoAlbumController@index');
    Route::post('videos/album', 'Admin\VideoAlbumController@post_add');
    Route::get('videos/album/{id}/edit', 'Admin\VideoAlbumController@index');
    Route::post('videos/album/{id}/edit', 'Admin\VideoAlbumController@post_edit');
    Route::get('videos/album/{id}/delete', 'Admin\VideoAlbumController@get_delete');

    //Customer
    // Route::get('customers/{type}', 'Admin\CustomerController@get_index');
    // Route::get('customers/{type}/archive/{year}', 'Admin\CustomerController@get_archive');

    // Route::get('customer/add', 'Admin\CustomerController@get_add');
    // Route::post('customer/add', 'Admin\CustomerController@post_add');
    // Route::get('customer/{id}/edit', 'Admin\CustomerController@get_edit');
    // Route::post('customer/{id}/edit', 'Admin\CustomerController@post_edit');
    // Route::get('customer/{id}/view', 'Admin\CustomerController@get_view');

    Route::get('customer/{id}/delete', 'Admin\CustomerController@get_delete');
    Route::get('customer/{id}/soft-delete', 'Admin\CustomerController@soft_delete');
    Route::get('customer/{id}/restore', 'Admin\CustomerController@get_restore');
    Route::get('customer/{id}/force-delete', 'Admin\CustomerController@force_delete');
    Route::get('customer/{id}/image-delete', 'Admin\CustomerController@image_delete');
    
    //Route::get('customers/trash', 'Admin\CustomerController@get_trash');

    // Route::get('status',array('as'=>'status','uses'=>'Admin\CustomerController@mystatus'));
    // Route::post('customer/{cid}/payment-method', 'Admin\CustomerController@post_payment_method');
    // Route::post('customer/{cid}/login', 'Admin\CustomerController@post_login');
    // Route::get('customer/{cid}/resend-verification-email', 'Admin\CustomerController@resend_verification_email');

    //Orders
    // Route::get('orders', 'Admin\OrderController@get_index');
    // Route::get('orders/archive/{year}', 'Admin\OrderController@get_archive');

    // Route::get('order/{id}/start-processing', 'Admin\OrderController@mark_start_processing');
    // Route::get('order/{id}/paid', 'Admin\OrderController@mark_paid');
    // Route::get('order/{id}/delivered', 'Admin\OrderController@mark_delivered');
    // Route::get('order/{id}/mark-as-dispatched', 'Admin\OrderController@mark_as_dispatched');

    // Route::get('order/add', 'Admin\OrderController@get_add');
    // Route::post('order/add', 'Admin\OrderController@post_add');
    // // Route::get('order/{id}/edit', 'Admin\OrderController@get_edit');
    // Route::post('order/{id}/edit', 'Admin\OrderController@post_edit');
    // Route::get('order/{id}/view', 'Admin\OrderController@get_view');

    // // Route::get('ordered-product/{id}/edit', 'Admin\OrderController@get_edit_ordered_items');
    // Route::post('ordered-product/{id}/edit', 'Admin\OrderController@post_edit_ordered_items');
    // Route::post('ordered-product/{id}/add', 'Admin\OrderController@post_add_ordered_items');
    // Route::get('ordered-product/{id}/force-delete', 'Admin\OrderController@get_force_delete_ordered_items');
    
    Route::get('order/{id}/delete', 'Admin\OrderController@get_delete');
    Route::get('order/{id}/soft-delete', 'Admin\OrderController@soft_delete');
    Route::get('order/{id}/restore', 'Admin\OrderController@get_restore');
    Route::get('order/{id}/force-delete', 'Admin\OrderController@force_delete');
    Route::get('order/{id}/image-delete', 'Admin\OrderController@image_delete');
    Route::get('orders/trash', 'Admin\OrderController@get_trash');

    // Route::post('repeat-transaction/{referenceTransactionId}/{c_id}', 'Admin\OrderController@post_repeat_transaction');
    // Route::post('refund-transaction/{referenceTransactionId}/{c_id}', 'Admin\OrderController@post_refund_transaction');
    // Route::get('order/{id}/invoice', 'Admin\OrderController@get_invoice');


    //Shipping
    Route::get('shippings', 'Admin\ShippingController@index');
    Route::post('shippings', 'Admin\ShippingController@post_add');
    Route::get('shipping/{id}/edit', 'Admin\ShippingController@index');
    Route::post('shipping/{id}/edit', 'Admin\ShippingController@post_edit');
    Route::get('shipping/{id}/delete', 'Admin\ShippingController@get_delete');

    //Payment
    Route::get('payments', 'Admin\PaymentController@index');
    Route::post('payments', 'Admin\PaymentController@post_add');
    Route::get('payment/{id}/edit', 'Admin\PaymentController@index');
    Route::post('payment/{id}/edit', 'Admin\PaymentController@post_edit');
    Route::get('payment/{id}/delete', 'Admin\PaymentController@get_delete');

    //Products
    Route::get('products', 'Admin\ProductController@get_index');
    Route::get('products/trash', 'Admin\ProductController@get_trash');
    Route::get('products/archive/{year}', 'Admin\ProductController@get_archive');
    Route::get('products/filter-by/{filter_type}', 'Admin\ProductController@filter_by');

    //  Products search by category filter, Search by name, Search by brand
    Route::post('filter', 'Admin\ProductController@post_filter_product_by_category');
    Route::get('filter/y-{year}', 'Admin\ProductController@get_filter1_y');
    Route::get('filter/b-{brand}', 'Admin\ProductController@get_filter1_b');
    Route::get('filter/m-{model}', 'Admin\ProductController@get_filter1_m');
    Route::get('filter/y-{year}/b-{brand}', 'Admin\ProductController@get_filter2_yb');
    Route::get('filter/y-{year}/m-{model}', 'Admin\ProductController@get_filter2_ym');
    Route::get('filter/b-{brand}/m-{model}', 'Admin\ProductController@get_filter2_bm');
    Route::get('filter/{mainCategory}/{subCategory}/{subCategoryType}', 'Admin\ProductController@get_filter3');

    Route::post('products/brand', 'Admin\ProductController@post_brand');
    Route::get('products/brands/{brandId}', 'Admin\ProductController@get_filter_brand');
    Route::post('products/search-by-word', 'Admin\ProductController@post_search_by_word');
    Route::get('products/product/{productId}', 'Admin\ProductController@get_filter_product');

    // Products CRUD
    Route::get('product/add', 'Admin\ProductController@get_add');
    Route::post('product/add', 'Admin\ProductController@post_add');
    Route::get('product/{id}/edit', 'Admin\ProductController@get_edit');
    Route::post('product/{id}/edit', 'Admin\ProductController@post_edit');
    Route::get('product/{id}/delete', 'Admin\ProductController@get_delete');
    Route::get('product/{id}/view', 'Admin\ProductController@get_view');
    Route::get('product/{id}/soft-delete', 'Admin\ProductController@soft_delete');
    Route::get('product/{id}/restore', 'Admin\ProductController@get_restore');
    Route::get('product/{id}/force-delete', 'Admin\ProductController@force_delete');

    Route::get('product/{id}/featured', 'Admin\ProductController@mark_featured');

    Route::get('product/{id}/image-delete', 'Admin\ProductController@image_delete');
    Route::get('product/{id}/main-image-delete', 'Admin\ProductController@main_image_delete');
    Route::get('product/{id}/video-delete', 'Admin\ProductController@video_delete');
    Route::get('product/{id}/source-delete', 'Admin\ProductController@source_delete');
    Route::get('product-photo/{pid}/delete', 'Admin\ProductController@photo_delete');

    //Product Category
    Route::get('products-category-menu', 'Admin\ProductCategoryController@select_product_category');
    // Route::get('products-category-type-menu', 'Admin\ProductCategoryTypeController@select_product_category_type');
    Route::get('products-sub-category-type-menu', 'Admin\ProductCategoryTypeController@select_product_sub_category_type');

    Route::get('products-category', 'Admin\ProductCategoryController@index');
    Route::post('products-category', 'Admin\ProductCategoryController@post_add');
    Route::get('products-category/{id}/edit', 'Admin\ProductCategoryController@index');
    Route::post('products-category/{id}/edit', 'Admin\ProductCategoryController@post_edit');
    Route::get('products-category/{id}/delete', 'Admin\ProductCategoryController@get_delete');
    Route::get('products-category/{id}/delete-image', 'Admin\ProductCategoryController@image_delete');

    //Product Category Sub
    Route::get('products-category-sub', 'Admin\ProductCategorySubController@index');
    Route::post('products-category-sub', 'Admin\ProductCategorySubController@post_add');
    Route::get('products-category-sub/{id}/edit', 'Admin\ProductCategorySubController@index');
    Route::post('products-category-sub/{id}/edit', 'Admin\ProductCategorySubController@post_edit');
    Route::get('products-category-sub/{id}/delete', 'Admin\ProductCategorySubController@get_delete');
    Route::get('products-category-sub/{id}/delete-image', 'Admin\ProductCategorySubController@image_delete');

    //Product Model
    Route::get('products-model', 'Admin\ProductModelController@index');
    Route::post('products-model', 'Admin\ProductModelController@post_add');
    Route::get('products-model/{id}/edit', 'Admin\ProductModelController@index');
    Route::post('products-model/{id}/edit', 'Admin\ProductModelController@post_edit');
    Route::get('products-model/{id}/delete', 'Admin\ProductModelController@get_delete');

    //Product Brand
    Route::get('products-brand', 'Admin\ProductBrandController@index');
    Route::post('products-brand', 'Admin\ProductBrandController@post_add');
    Route::get('products-brand/{id}/edit', 'Admin\ProductBrandController@index');
    Route::post('products-brand/{id}/edit', 'Admin\ProductBrandController@post_edit');
    Route::get('products-brand/{id}/delete', 'Admin\ProductBrandController@get_delete');
    Route::get('products-brand/{id}/delete-image', 'Admin\ProductBrandController@image_delete');

    //Sales Person
    Route::get('sales-person', 'Admin\SalesPersonController@index');
    Route::post('sales-person', 'Admin\SalesPersonController@post_add');
    Route::get('sales-person/{id}/edit', 'Admin\SalesPersonController@index');
    Route::post('sales-person/{id}/edit', 'Admin\SalesPersonController@post_edit');
    Route::get('sales-person/{id}/delete', 'Admin\SalesPersonController@get_delete');
    Route::get('sales-person/{id}/delete-image', 'Admin\SalesPersonController@image_delete');

    //produ
    Route::get('display-type/{id?}', 'Admin\DisplayProductController@index');
    Route::post('display-type/{id?}', 'Admin\DisplayProductController@post_add');
    Route::get('display-type/{id}/delete', 'Admin\DisplayProductController@get_delete');
    Route::get('get-product-by-type/{id}', 'Admin\DisplayProductController@get_products_by_type');

    //rsr product display type
    Route::get('rsr-display-type/{id?}', 'Admin\DisplayRsrProductController@index');
    Route::post('rsr-display-type/{id?}', 'Admin\DisplayRsrProductController@post_add');
    Route::get('rsr-display-type/{id}/delete', 'Admin\DisplayRsrProductController@get_delete');
    Route::get('get-rsr-product-by-type/{id}', 'Admin\DisplayRsrProductController@get_products_by_type');

    //Product Category Type
    Route::get('products-category-type', 'Admin\ProductCategoryTypeController@index');
    Route::post('products-category-type', 'Admin\ProductCategoryTypeController@post_add');
    Route::get('products-category-type/{id}/edit', 'Admin\ProductCategoryTypeController@index');
    Route::post('products-category-type/{id}/edit', 'Admin\ProductCategoryTypeController@post_edit');
    Route::get('products-category-type/{id}/delete', 'Admin\ProductCategoryTypeController@get_delete');
    Route::get('products-category-type/{id}/delete-image', 'Admin\ProductCategoryTypeController@image_delete');

    //Product Color
    Route::get('products-color', 'Admin\ProductColorController@index');
    Route::post('products-color', 'Admin\ProductColorController@post_add');
    Route::get('products-color/{id}/edit', 'Admin\ProductColorController@index');
    Route::post('products-color/{id}/edit', 'Admin\ProductColorController@post_edit');
    Route::get('products-color/{id}/delete', 'Admin\ProductColorController@get_delete');
    Route::get('products-color/{id}/delete-image', 'Admin\ProductColorController@image_delete');

    //Product Size
    Route::get('products-size', 'Admin\ProductSizeController@index');
    Route::post('products-size', 'Admin\ProductSizeController@post_add');
    Route::get('products-size/{id}/edit', 'Admin\ProductSizeController@index');
    Route::post('products-size/{id}/edit', 'Admin\ProductSizeController@post_edit');
    Route::get('products-size/{id}/delete', 'Admin\ProductSizeController@get_delete');
    Route::get('products-size/{id}/delete-image', 'Admin\ProductSizeController@image_delete');

    //Occasion Products
    Route::get('occasion-product', 'Admin\ProductOccasionController@index');
    Route::post('occasion-product', 'Admin\ProductOccasionController@post_add');
    Route::get('occasion-product/{id}/edit', 'Admin\ProductOccasionController@index');
    Route::post('occasion-product/{id}/edit', 'Admin\ProductOccasionController@post_edit');
    Route::get('occasion-product/{id}/delete', 'Admin\ProductOccasionController@get_delete');
    Route::get('occasion-product/{id}/delete-image', 'Admin\ProductOccasionController@image_delete');
    
    // Product Import
    Route::get('products/xlsx-import', 'Admin\ProductController@get_import');
    Route::post('products/xlsx-import', 'Admin\ProductController@post_import');
    Route::post('products/zip-import', 'Admin\ProductController@zip_post_import');
    Route::get('products/un-zip', 'Admin\ProductController@unzip');

    // Date Import
    Route::get('data-imports', 'Admin\DataImportController@get_import');
    Route::post('data-imports', 'Admin\DataImportController@post_import');
    Route::post('products/zip-import', 'Admin\DataImportController@zip_post_import');
    Route::get('products/un-zip', 'Admin\DataImportController@unzip');
    
    //Our Services
    Route::get('our-services', 'Admin\OurServicesController@index');
    Route::get('our-service/add', 'Admin\OurServicesController@get_add');
    Route::post('our-service/add', 'Admin\OurServicesController@post_add');
    Route::get('our-service/{id}/edit', 'Admin\OurServicesController@get_edit');
    Route::post('our-service/{id}/edit', 'Admin\OurServicesController@post_edit');
    Route::get('our-service/{id}/delete', 'Admin\OurServicesController@get_delete');
    Route::get('our-service/{id}/view', 'Admin\OurServicesController@get_view');
    Route::get('our-services/trash', 'Admin\OurServicesController@get_trash');
    Route::get('our-service/{id}/soft-delete', 'Admin\OurServicesController@soft_delete');
    Route::get('our-service/{id}/restore', 'Admin\OurServicesController@get_restore');
    Route::get('our-service/{id}/force-delete', 'Admin\OurServicesController@force_delete');
    Route::get('our-service/{id}/image-delete', 'Admin\OurServicesController@image_delete');
    
    // Theme Settings
    Route::get('theme-settings', 'Admin\ThemeSettingsController@get_edit');
    Route::post('theme-settings', 'Admin\ThemeSettingsController@post_edit');
    
    // Section Info
    Route::get('section-info', 'Admin\SectionInfoController@get_edit');
    Route::post('section-info', 'Admin\SectionInfoController@post_edit');

    // Theme Settings
    Route::get('section-offer', 'Admin\SectionOfferController@get_edit');
    Route::post('section-offer', 'Admin\SectionOfferController@post_edit');
    Route::get('section-offers/delete-offer-image', 'Admin\SectionOfferController@delete_offer_image');
    Route::get('section-offers/delete-offer-image2', 'Admin\SectionOfferController@delete_offer_image2');

    // Product Settings
    Route::get('section-product', 'Admin\SectionProductController@get_edit');
    Route::post('section-product', 'Admin\SectionProductController@post_edit');

    //Add Color to product 
    Route::post('{prid}/price/add', 'Admin\ProductController@post_price');
    Route::get('price/{id}/view', 'Admin\ProductController@post_price_view');
    Route::post('{prid}/price/{id}/edit', 'Admin\ProductController@get_price_edit');
    Route::get('price/{id}/soft-delete', 'Admin\ProductController@price_soft_delete');
    Route::get('price/trash', 'Admin\ProductController@get_price_trash');
    Route::get('price/{id}/restore', 'Admin\ProductController@price_get_restore');
    Route::get('price/{id}/force-delete', 'Admin\ProductController@price_force_delete');

    //Add Size to product 
    Route::post('{prid}/size/add', 'Admin\ProductController@post_size');
    Route::get('size/{id}/view', 'Admin\ProductController@post_size_view');
    Route::post('{prid}/size/{id}/edit', 'Admin\ProductController@get_size_edit');
    Route::get('size/{id}/soft-delete', 'Admin\ProductController@size_soft_delete');
    Route::get('size/trash', 'Admin\ProductController@get_size_trash');
    Route::get('size/{id}/restore', 'Admin\ProductController@size_get_restore');
    Route::get('size/{id}/force-delete', 'Admin\ProductController@size_force_delete');

    //Newsletter
    Route::get('subscribes', 'Admin\SubscribeController@get_index');
    Route::get('subscribes/archive/{year}', 'Admin\SubscribeController@get_archive');
    Route::get('subscribes/trash', 'Admin\SubscribeController@get_trash');
    Route::get('subscribes/export/csv', 'Admin\SubscribeController@get_export_csv');
    Route::get('subscribe/{id}/soft-delete', 'Admin\SubscribeController@soft_delete');
    Route::get('subscribe/{id}/restore', 'Admin\SubscribeController@get_restore');
    Route::get('subscribe/{id}/force-delete', 'Admin\SubscribeController@force_delete');

    //Testimonial
    Route::get('testimonials', 'Admin\TestimonialController@get_index');
    Route::get('testimonials/archive/{year}', 'Admin\TestimonialController@get_archive');
    Route::get('testimonials/trash', 'Admin\TestimonialController@get_trash');

    Route::get('testimonial/add', 'Admin\TestimonialController@get_add');
    Route::post('testimonial/add', 'Admin\TestimonialController@post_add');
    Route::get('testimonial/{id}/edit', 'Admin\TestimonialController@get_edit');
    Route::post('testimonial/{id}/edit', 'Admin\TestimonialController@post_edit');
    Route::get('testimonial/{id}/view', 'Admin\TestimonialController@get_view');
    Route::get('testimonial/{id}/soft-delete', 'Admin\TestimonialController@soft_delete');
    Route::get('testimonial/{id}/restore', 'Admin\TestimonialController@get_restore');
    Route::get('testimonial/{id}/force-delete', 'Admin\TestimonialController@force_delete');
    Route::get('testimonial/{id}/image-delete', 'Admin\TestimonialController@image_delete');

    //Coupon
    Route::get('coupons', 'Admin\CouponController@get_index');
    Route::get('coupons/archive/{year}', 'Admin\CouponController@get_archive');
    Route::get('coupons/trash', 'Admin\CouponController@get_trash');

    Route::get('coupon/add', 'Admin\CouponController@get_add');
    Route::post('coupon/add', 'Admin\CouponController@post_add');
    Route::get('coupon/{id}/edit', 'Admin\CouponController@get_edit');
    Route::post('coupon/{id}/edit', 'Admin\CouponController@post_edit');
    Route::get('coupon/{id}/view', 'Admin\CouponController@get_view');
    Route::get('coupon/{id}/send-guests', 'Admin\CouponController@get_send_guests');
    Route::get('coupon/{id}/send-subscribers', 'Admin\CouponController@get_send_subscribers');
    Route::get('coupon/{id}/soft-delete', 'Admin\CouponController@soft_delete');
    Route::get('coupon/{id}/restore', 'Admin\CouponController@get_restore');
    Route::get('coupon/{id}/force-delete', 'Admin\CouponController@force_delete');

    //Category Slider
    Route::get('home-sliders', 'Admin\HomeSliderController@index');
    Route::get('home-slider/add', 'Admin\HomeSliderController@get_add');
    Route::post('home-slider/add', 'Admin\HomeSliderController@post_add');
    Route::get('home-slider/{id}/edit', 'Admin\HomeSliderController@get_edit');
    Route::post('home-slider/{id}/edit', 'Admin\HomeSliderController@post_edit');
    Route::get('home-slider/{id}/delete', 'Admin\HomeSliderController@get_delete');
    Route::get('home-slider/{id}/view', 'Admin\HomeSliderController@get_view');
    Route::get('home-sliders/trash', 'Admin\HomeSliderController@get_trash');
    Route::get('home-slider/{id}/soft-delete', 'Admin\HomeSliderController@soft_delete');
    Route::get('home-slider/{id}/restore', 'Admin\HomeSliderController@get_restore');
    Route::get('home-slider/{id}/force-delete', 'Admin\HomeSliderController@force_delete');
    Route::get('home-slider/{id}/image-delete', 'Admin\HomeSliderController@image_delete');

    //Blog
    Route::get('blogs', 'Admin\BlogController@index');
    Route::get('blog/add', 'Admin\BlogController@get_add');
    Route::post('blog/add', 'Admin\BlogController@post_add');
    Route::get('blog/{id}/edit', 'Admin\BlogController@get_edit');
    Route::post('blog/{id}/edit', 'Admin\BlogController@post_edit');
    Route::get('blog/{id}/delete', 'Admin\BlogController@get_delete');
    Route::get('blog/{id}/view', 'Admin\BlogController@get_view');
    Route::get('blogs/trash', 'Admin\BlogController@get_trash');
    Route::get('blog/{id}/soft-delete', 'Admin\BlogController@soft_delete');
    Route::get('blog/{id}/restore', 'Admin\BlogController@get_restore');
    Route::get('blog/{id}/force-delete', 'Admin\BlogController@force_delete');
    Route::get('blog/{id}/image-delete', 'Admin\BlogController@image_delete');

    //Blog category
    Route::get('blogs/category', 'Admin\BlogCategoryController@index');
    Route::post('blogs/category', 'Admin\BlogCategoryController@post_add');
    Route::get('blogs/category/{id}/edit', 'Admin\BlogCategoryController@index');
    Route::post('blogs/category/{id}/edit', 'Admin\BlogCategoryController@post_edit');
    Route::get('blogs/category/{id}/delete', 'Admin\BlogCategoryController@get_delete');

    //Review
    Route::get('reviews', 'Admin\ReviewController@get_index');
    Route::get('reviews/archive/{year}', 'Admin\ReviewController@get_archive');
    Route::get('reviews/trash', 'Admin\ReviewController@get_trash');

    Route::get('review/{id}/view', 'Admin\ReviewController@get_view');
    Route::post('review/{id}/approve', 'Admin\ReviewController@post_approve');
    Route::get('review/{id}/soft-delete', 'Admin\ReviewController@soft_delete');
    Route::get('review/{id}/restore', 'Admin\ReviewController@get_restore');
    Route::get('review/{id}/force-delete', 'Admin\ReviewController@force_delete');

    //Store
    Route::get('stores', 'Admin\StoreController@get_index');
    Route::get('stores/trash', 'Admin\StoreController@get_trash');
    Route::get('stores/archive/{year}', 'Admin\StoreController@get_archive');

    Route::get('store/add', 'Admin\StoreController@get_add');
    Route::post('store/add', 'Admin\StoreController@post_add');
    Route::get('store/{id}/edit', 'Admin\StoreController@get_edit');
    Route::post('store/{id}/edit', 'Admin\StoreController@post_edit');
    Route::get('store/{id}/delete', 'Admin\StoreController@get_delete');
    Route::get('store/{id}/view', 'Admin\StoreController@get_view');
    Route::get('store/{id}/soft-delete', 'Admin\StoreController@soft_delete');
    Route::get('store/{id}/restore', 'Admin\StoreController@get_restore');
    Route::get('store/{id}/force-delete', 'Admin\StoreController@force_delete');
    Route::get('store/{id}/image-delete', 'Admin\StoreController@image_delete');

    // //Store Products
    // Route::get('store-products', 'Admin\StoreProductController@get_index');
    // Route::get('store-products/trash', 'Admin\StoreProductController@get_trash');
    // Route::get('store-products/archive/{year}', 'Admin\StoreProductController@get_archive');

    Route::get('store-product/add', 'Admin\StoreProductController@get_add');
    Route::post('store-product/add', 'Admin\StoreProductController@post_add');
    Route::get('store-product/{id}/edit', 'Admin\StoreProductController@get_edit');
    Route::post('store-product/{id}/edit', 'Admin\StoreProductController@post_edit');
    Route::get('store-product/{id}/delete', 'Admin\StoreProductController@get_delete');
    Route::get('store-product/{id}/view', 'Admin\StoreProductController@get_view');
    Route::get('store-product/{id}/soft-delete', 'Admin\StoreProductController@soft_delete');
    Route::get('store-product/{id}/restore', 'Admin\StoreProductController@get_restore');
    Route::get('store-product/{id}/force-delete', 'Admin\StoreProductController@force_delete');
    Route::get('store-product/{id}/image-delete', 'Admin\StoreProductController@image_delete');

    // Route::post('store-product-status', 'Admin\StoreProductController@post_status');

    // Course Category
    Route::get('stores-category', 'Admin\StoreCategoryController@index');
    Route::post('stores-category', 'Admin\StoreCategoryController@post_add');
    Route::get('stores-category/{id}/edit', 'Admin\StoreCategoryController@index');
    Route::post('stores-category/{id}/edit', 'Admin\StoreCategoryController@post_edit');
    Route::get('stores-category/{id}/delete', 'Admin\StoreCategoryController@get_delete');
    Route::get('stores-category/{id}/delete-image', 'Admin\StoreCategoryController@image_delete');

    Route::get('stores-category-menu', 'Admin\StoreCategoryController@select_devision');

    // Store Manager
    Route::get('store-manager', 'Admin\StoreManagerController@index');
    Route::post('store-manager', 'Admin\StoreManagerController@post_add');
    Route::get('store-manager/{id}/edit', 'Admin\StoreManagerController@index');
    Route::post('store-manager/{id}/edit', 'Admin\StoreManagerController@post_edit');
    Route::get('store-manager/{id}/delete', 'Admin\StoreManagerController@get_delete');
    Route::get('store-manager/{id}/delete-image', 'Admin\StoreManagerController@image_delete');

    //Companies
    Route::get('companies', 'Admin\CompanyController@index');
    Route::get('company/add', 'Admin\CompanyController@get_add');
    Route::post('company/add', 'Admin\CompanyController@post_add');
    Route::get('company/{id}/edit', 'Admin\CompanyController@get_edit');
    Route::post('company/{id}/edit', 'Admin\CompanyController@post_edit');
    Route::get('company/{id}/delete', 'Admin\CompanyController@get_delete');
    Route::get('company/{id}/view', 'Admin\CompanyController@get_view');
    Route::get('companies/trash', 'Admin\CompanyController@get_trash');
    Route::get('company/{id}/soft-delete', 'Admin\CompanyController@soft_delete');
    Route::get('company/{id}/restore', 'Admin\CompanyController@get_restore');
    Route::get('company/{id}/force-delete', 'Admin\CompanyController@force_delete');
    Route::get('company/{id}/image-delete', 'Admin\CompanyController@image_delete');

    // Product Import
    Route::get('import/category', 'Admin\ImportController@get_category');
    Route::post('import/category', 'Admin\ImportController@post_category');
    Route::get('import/product', 'Admin\ImportController@get_product');
    Route::post('import/product', 'Admin\ImportController@post_product');
    
    Route::get('import/split', 'Admin\ImportController@get_split');
    Route::post('import/split', 'Admin\ImportController@post_split');

    Route::post('import/zip-import', 'Admin\ImportController@zip_post_import');
    Route::get('import/un-zip', 'Admin\ImportController@unzip');

    // RSR  Products
    Route::get('rsr-products', 'Admin\RsrProductController@get_index');
    Route::get('rsr-products/trash', 'Admin\RsrProductController@get_trash');
    Route::get('rsr-products/archive/{year}', 'Admin\RsrProductController@get_archive');
    Route::get('rsr-products/filter-by/{filter_type}', 'Admin\RsrProductController@filter_by');
    Route::get('rsr-product/add', 'Admin\RsrProductController@get_add');
    Route::post('rsr-product/add', 'Admin\RsrProductController@post_add');
    Route::get('rsr-product/{id}/edit', 'Admin\RsrProductController@get_edit');
    Route::post('rsr-product/{id}/edit', 'Admin\RsrProductController@post_edit');
    Route::get('rsr-product/{id}/delete', 'Admin\RsrProductController@get_delete');
    Route::get('rsr-product/{id}/view', 'Admin\RsrProductController@get_view');
    Route::get('rsr-product/{id}/soft-delete', 'Admin\RsrProductController@soft_delete');
    Route::get('rsr-product/{id}/restore', 'Admin\RsrProductController@get_restore');
    Route::get('rsr-product/{id}/force-delete', 'Admin\RsrProductController@force_delete');
    Route::get('rsr-product/{id}/featured', 'Admin\RsrProductController@mark_featured');
    Route::get('rsr-product/{id}/image-delete', 'Admin\RsrProductController@image_delete');
    Route::get('rsr-product/{id}/main-image-delete', 'Admin\RsrProductController@main_image_delete');
    Route::get('rsr-product/{id}/video-delete', 'Admin\RsrProductController@video_delete');
    Route::get('rsr-product/{id}/source-delete', 'Admin\RsrProductController@source_delete');
    Route::get('rsr-product-photo/{pid}/delete', 'Admin\RsrProductController@photo_delete');

    // Rsr Main Category
    Route::get('rsr-main-categories', 'Admin\RsrMainCategoryController@index');
    Route::post('rsr-main-categories', 'Admin\RsrMainCategoryController@post_add');
    Route::get('rsr-main-category/{id}/edit', 'Admin\RsrMainCategoryController@index');
    Route::post('rsr-main-category/{id}/edit', 'Admin\RsrMainCategoryController@post_edit');
    Route::get('rsr-main-category/{id}/delete', 'Admin\RsrMainCategoryController@get_delete');
    Route::get('rsr-main-category/{id}/delete-image', 'Admin\RsrMainCategoryController@image_delete');

    //RSR Sub Categories
    Route::get('rsr-sub-categories', 'Admin\RsrSubCategoryController@index');
    Route::post('rsr-sub-categories', 'Admin\RsrSubCategoryController@post_add');
    Route::get('rsr-sub-category/{id}/edit', 'Admin\RsrSubCategoryController@index');
    Route::post('rsr-sub-category/{id}/edit', 'Admin\RsrSubCategoryController@post_edit');
    Route::get('rsr-sub-category/{id}/delete', 'Admin\RsrSubCategoryController@get_delete');
    Route::get('rsr-sub-category/{id}/delete-image', 'Admin\RsrSubCategoryController@image_delete');

    //Rsr Category Groups
    Route::get('rsr-category-groups', 'Admin\RsrCategoryGroupController@index');
    Route::post('rsr-category-groups', 'Admin\RsrCategoryGroupController@post_add');
    Route::get('rsr-category-group/{id}/edit', 'Admin\RsrCategoryGroupController@index');
    Route::post('rsr-category-group/{id}/edit', 'Admin\RsrCategoryGroupController@post_edit');
    Route::get('rsr-category-group/{id}/delete', 'Admin\RsrCategoryGroupController@get_delete');
    Route::get('rsr-category-group/{id}/delete-image', 'Admin\RsrCategoryGroupController@image_delete');

    //Category Groups
    Route::get('category-groups', 'Admin\CategoryGroupController@index');
    Route::post('category-groups', 'Admin\CategoryGroupController@post_add');
    Route::get('category-group/{id}/edit', 'Admin\CategoryGroupController@index');
    Route::post('category-group/{id}/edit', 'Admin\CategoryGroupController@post_edit');
    Route::get('category-group/{id}/delete', 'Admin\CategoryGroupController@get_delete');
    Route::get('category-group/{id}/delete-image', 'Admin\CategoryGroupController@image_delete');

    //Newsletter
    Route::get('product-notifications', 'Admin\ProductNotificationController@get_index');
    Route::get('product-notifications/archive/{year}', 'Admin\ProductNotificationController@get_archive');
    Route::get('product-notifications/trash', 'Admin\ProductNotificationController@get_trash');
    Route::get('product-notifications/export/csv', 'Admin\ProductNotificationController@get_export_csv');
    Route::get('product-notification/{id}/soft-delete', 'Admin\ProductNotificationController@soft_delete');
    Route::get('product-notification/{id}/restore', 'Admin\ProductNotificationController@get_restore');
    Route::get('product-notification/{id}/force-delete', 'Admin\ProductNotificationController@force_delete');

    // RSR Retail MARKUP
    Route::get('rsr-retail-markup', 'Admin\RsrMainCategoryController@get_rsr_retail_markup');
    Route::post('rsr-retail-markup', 'Admin\RsrMainCategoryController@post_rsr_retail_markup');

    // RSR main category filter attributes display
    Route::get('rsr-main-category-filter-attributes', 'Admin\RsrMainCategoryController@get_rsr_main_category_filter_attributes');
    Route::post('rsr-main-category-filter-attributes', 'Admin\RsrMainCategoryController@post_rsr_main_category_filter_attributes');
    
    // Artisan Call
    Route::get('storage-link', function () {Artisan::call('storage:link');});
});

Route::group(['prefix' => 'admin', 'middleware' =>  ['auth']], function () {
    //User
    Route::get('user/profile', 'Admin\UserController@get_profile');
    Route::post('user/profile', 'Admin\UserController@post_profile');

    //Home
    Route::get('dashboard', 'Admin\HomeController@index');
});

Route::group(['prefix' => 'admin', 'middleware' =>  ['auth', 'role:super-admin|admin|manager']], function () {
    //Store Products
    Route::get('store-products', 'Admin\StoreProductController@get_index');
    Route::get('store-products/trash', 'Admin\StoreProductController@get_trash');
    Route::get('store-products/archive/{year}', 'Admin\StoreProductController@get_archive');
    Route::post('store-product-status', 'Admin\StoreProductController@post_status');
    
    //Customer
    Route::get('customers/{type}', 'Admin\CustomerController@get_index');
    Route::get('customers/{type}/archive/{year}', 'Admin\CustomerController@get_archive');

    Route::get('customer/add', 'Admin\CustomerController@get_add');
    Route::post('customer/add', 'Admin\CustomerController@post_add');
    Route::get('customer/{id}/edit', 'Admin\CustomerController@get_edit');
    Route::post('customer/{id}/edit', 'Admin\CustomerController@post_edit');
    Route::get('customer/{id}/view', 'Admin\CustomerController@get_view');

    // Route::get('customer/{id}/delete', 'Admin\CustomerController@get_delete');
    // Route::get('customer/{id}/soft-delete', 'Admin\CustomerController@soft_delete');
    // Route::get('customer/{id}/restore', 'Admin\CustomerController@get_restore');
    // Route::get('customer/{id}/force-delete', 'Admin\CustomerController@force_delete');
    // Route::get('customer/{id}/image-delete', 'Admin\CustomerController@image_delete');
    // Route::get('customers/trash', 'Admin\CustomerController@get_trash');

    Route::get('status',array('as'=>'status','uses'=>'Admin\CustomerController@mystatus'));
    Route::post('customer/{cid}/payment-method', 'Admin\CustomerController@post_payment_method');
    Route::post('customer/{cid}/login', 'Admin\CustomerController@post_login');
    Route::get('customer/{cid}/resend-verification-email', 'Admin\CustomerController@resend_verification_email');


    //Orders
    Route::get('orders', 'Admin\OrderController@get_index');
    Route::get('orders/archive/{year}', 'Admin\OrderController@get_archive');

    Route::get('order/{id}/start-processing', 'Admin\OrderController@mark_start_processing');
    Route::get('order/{id}/paid', 'Admin\OrderController@mark_paid');
    Route::get('order/{id}/delivered', 'Admin\OrderController@mark_delivered');
    Route::get('order/{id}/mark-as-dispatched', 'Admin\OrderController@mark_as_dispatched');

    Route::get('order/add', 'Admin\OrderController@get_add');
    Route::post('order/add', 'Admin\OrderController@post_add');
    // Route::get('order/{id}/edit', 'Admin\OrderController@get_edit');
    Route::post('order/{id}/edit', 'Admin\OrderController@post_edit');
    Route::get('order/{id}/view', 'Admin\OrderController@get_view');
    
    // Route::get('ordered-product/{id}/edit', 'Admin\OrderController@get_edit_ordered_items');
    Route::post('ordered-product/{id}/edit', 'Admin\OrderController@post_edit_ordered_items');
    Route::post('ordered-product/{id}/add', 'Admin\OrderController@post_add_ordered_items');
    Route::get('ordered-product/{id}/force-delete', 'Admin\OrderController@get_force_delete_ordered_items');
    
    // Route::get('order/{id}/delete', 'Admin\OrderController@get_delete');
    // Route::get('order/{id}/soft-delete', 'Admin\OrderController@soft_delete');
    // Route::get('order/{id}/restore', 'Admin\OrderController@get_restore');
    // Route::get('order/{id}/force-delete', 'Admin\OrderController@force_delete');
    // Route::get('order/{id}/image-delete', 'Admin\OrderController@image_delete');
    // Route::get('orders/trash', 'Admin\OrderController@get_trash');

    Route::post('repeat-transaction/{referenceTransactionId}/{c_id}', 'Admin\OrderController@post_repeat_transaction');
    Route::post('refund-transaction/{referenceTransactionId}/{c_id}', 'Admin\OrderController@post_refund_transaction');
    Route::get('order/{id}/invoice', 'Admin\OrderController@get_invoice');

    Route::post('order/update-status', 'Admin\OrderController@update_status')->name('order.update_status');

});