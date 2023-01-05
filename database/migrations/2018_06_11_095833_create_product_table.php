<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('color')->nullable();
            $table->mediumText('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // Schema::create('product_sub_categories', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->unsignedInteger('main_category_id');
        //     $table->string('title')->nullable();
        //     $table->string('slug')->nullable();
        //     $table->string('image')->nullable();
        //     $table->string('color')->nullable();
        //     $table->mediumText('description')->nullable();
        //     $table->boolean('status')->default(true);
        //     $table->timestamps();
        // });

        Schema::create('subcategory_types', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sub_category_id');
            $table->string('title');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->string('color')->nullable();
            $table->mediumText('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('product_brands', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sales_person_id');
            $table->string('title');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->string('color')->nullable();
            $table->mediumText('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('product_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->string('color')->nullable();
            $table->mediumText('description')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        Schema::create('colors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->string('color')->nullable();
            $table->mediumText('description')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        Schema::create('products_photo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->string('image');
            $table->string('title')->nullable();
            $table->unsignedInteger('order');
            $table->timestamps();
        });

        Schema::create('products_view', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->string('ip', 20);
            $table->timestamps();
        });

        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('title')->nullable();
            $table->boolean('coupon_type')->nullable();
            $table->string('series_no')->nullable();
            $table->string('pin_no')->nullable();
            $table->integer('percentage')->nullable();
            $table->integer('count')->nullable();
            $table->integer('use_count')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->string('image')->nullable();
            $table->string('color')->nullable();
            $table->mediumText('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Store Divisions/Category
        Schema::create('store_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('title');
            $table->mediumText('description')->nullable();
            $table->string('slug');
            $table->string('image')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Store
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('division', 100)->nullable();
            $table->string('banner', 100)->nullable();
            $table->string('legacy', 100)->nullable();
            $table->unsignedInteger('store_id')->nullable();
            $table->unsignedInteger('store_category_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('zip', 100)->nullable();
            $table->string('phone_no', 20)->nullable();
            $table->string('mobile_no', 20)->nullable();
            $table->string('slug')->nullable();
            $table->mediumText('short_description')->nullable();
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('store_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id');
            $table->unsignedInteger('product_id');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('title');
            $table->text('short_description')->nullable();
            $table->longText('content')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('url', 250)->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sales_person', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('title')->nullable();
            $table->string('phone_no', 20)->nullable();
            $table->string('email')->nullable();
            $table->mediumText('description')->nullable();
            $table->string('slug');
            $table->string('image')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        Schema::create('brand_sales_person', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('brand_id');
            $table->unsignedInteger('sales_person_id');
            $table->timestamps();
        });

        Schema::create('sales_person_has_stores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sales_person_id');
            $table->unsignedInteger('store_id');
            $table->timestamps();
        });

        Schema::create('display_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('type')->nullable()->comment('#1-Featured, #2-New');
            $table->unsignedInteger('store_type')->nullable()->comment('#0-Boomstick, #1-RSR');
            // $table->unsignedInteger('product_id')->nullable();
            $table->string('product_id')->nullable();
            $table->timestamps();
        });

        Schema::create('store_managers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('slug')->nullable();
            $table->string('email')->nullable();
            $table->string('image')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('address_1')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->string('phone_no', 20)->nullable();
            $table->string('mobile_no', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('store_manager_has_stores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_manager_id');
            $table->unsignedInteger('store_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_manager_has_stores');
        Schema::dropIfExists('store_managers');
        Schema::dropIfExists('brand_sales_person');
        Schema::dropIfExists('sales_person');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('store_products');
        Schema::dropIfExists('stores');
        Schema::dropIfExists('store_categories');
        Schema::dropIfExists('products_view');
        Schema::dropIfExists('products_photo');
        Schema::dropIfExists('products');
        Schema::dropIfExists('products_models');
        Schema::dropIfExists('product_brands');
        Schema::dropIfExists('product_category_sub');
        Schema::dropIfExists('product_category');
    }
}
