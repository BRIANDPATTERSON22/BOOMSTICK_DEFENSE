<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEcommerceSiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_id')->nullable();
            $table->string('title')->nullable();
            $table->string('upc')->nullable();
            $table->string('sku')->nullable();
            $table->string('slug')->nullable();

            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('main_category_id')->nullable();
            $table->unsignedInteger('sub_category_id')->nullable();
            $table->unsignedInteger('sub_category_type_id')->nullable();
            $table->unsignedInteger('brand_id')->nullable();
            $table->unsignedInteger('model_id')->nullable();
            $table->unsignedInteger('color_id')->nullable();

            $table->decimal('quantity', 8,2)->nullable();
            $table->decimal('quantity_step_by', 8,2)->default(1)->nullable();
            $table->decimal('price', 10,2)->nullable();
            $table->decimal('discount_percentage', 5,2)->nullable();
            $table->decimal('dicounted_price', 10,2)->nullable();
            $table->decimal('vat', 10,2)->nullable();
            $table->decimal('tax', 10,2)->nullable();

            $table->dateTime('offer_started_at')->nullable();
            $table->dateTime('offer_ended_at')->nullable();
            $table->dateTime('available_at')->nullable();

            $table->mediumText('short_description')->nullable();
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->string('main_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('video')->nullable();
            $table->string('youtube')->nullable();
            $table->string('vimeo')->nullable();
            $table->string('audio')->nullable();
            $table->string('soundcloud')->nullable();

            $table->string('warranty')->nullable();
            $table->string('external_link')->nullable();
            $table->string('material_type')->nullable();

            $table->string('size')->nullable();
            $table->string('weight')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();

            $table->boolean('is_featured')->default(false)->nullable();
            $table->boolean('is_purchase_enabled')->default(true)->nullable();
            $table->boolean('is_review_enabled')->default(true)->nullable();
            $table->boolean('is_retail_price_enabled')->default(true)->nullable();

            $table->boolean('is_firearm')->default(false)->nullable();
            $table->boolean('is_disclaimer_agreement_enabled')->default(false)->nullable();
            $table->boolean('is_warning_enabled')->default(false)->nullable();

            $table->string('rsr_stock_number')->nullable();
            $table->string('upc_code')->nullable();
            $table->text('product_description')->nullable();
            $table->string('department_number')->nullable();
            $table->string('manufacturer_id')->nullable();
            $table->string('retail_price')->nullable();
            $table->string('rsr_pricing')->nullable();
            $table->string('product_weight')->nullable();
            $table->string('inventory_quantity')->nullable();
            $table->text('model')->nullable();
            $table->string('full_manufacturer_name')->nullable();
            $table->string('manufacturer_part_number')->nullable();
            $table->string('allocated_closeout_deleted')->nullable();
            $table->text('expanded_product_description')->nullable();
            $table->string('image_name')->nullable();
            $table->string('ak', 10)->nullable();
            $table->string('al', 10)->nullable();
            $table->string('ar', 10)->nullable();
            $table->string('az', 10)->nullable();
            $table->string('ca', 10)->nullable();
            $table->string('co', 10)->nullable();
            $table->string('ct', 10)->nullable();
            $table->string('dc', 10)->nullable();
            $table->string('de', 10)->nullable();
            $table->string('fl', 10)->nullable();
            $table->string('ga', 10)->nullable();
            $table->string('hi', 10)->nullable();
            $table->string('ia', 10)->nullable();
            $table->string('id_idaho', 10)->nullable();
            $table->string('il', 10)->nullable();
            $table->string('in', 10)->nullable();
            $table->string('ks', 10)->nullable();
            $table->string('ky', 10)->nullable();
            $table->string('la', 10)->nullable();
            $table->string('ma', 10)->nullable();
            $table->string('md', 10)->nullable();
            $table->string('me', 10)->nullable();
            $table->string('mi', 10)->nullable();
            $table->string('mn', 10)->nullable();
            $table->string('mo', 10)->nullable();
            $table->string('ms', 10)->nullable();
            $table->string('mt', 10)->nullable();
            $table->string('nc', 10)->nullable();
            $table->string('nd', 10)->nullable();
            $table->string('ne', 10)->nullable();
            $table->string('nh', 10)->nullable();
            $table->string('nj', 10)->nullable();
            $table->string('nm', 10)->nullable();
            $table->string('nv', 10)->nullable();
            $table->string('ny', 10)->nullable();
            $table->string('oh', 10)->nullable();
            $table->string('ok', 10)->nullable();
            $table->string('or', 10)->nullable();
            $table->string('ph', 10)->nullable();
            $table->string('ri', 10)->nullable();
            $table->string('sc', 10)->nullable();
            $table->string('sd', 10)->nullable();
            $table->string('tn', 10)->nullable();
            $table->string('tx', 10)->nullable();
            $table->string('ut', 10)->nullable();
            $table->string('va', 10)->nullable();
            $table->string('vt', 10)->nullable();
            $table->string('wa', 10)->nullable();
            $table->string('wi', 10)->nullable();
            $table->string('wv', 10)->nullable();
            $table->string('wy', 10)->nullable();
            $table->string('ground_shipments_only', 10)->nullable();
            $table->string('adult_signature_required', 10)->nullable();
            $table->string('blocked_from_dropship', 10)->nullable();
            $table->string('date_entered', 20)->nullable();
            $table->string('retail_map')->nullable();
            $table->string('image_disclaimer', 10)->nullable();
            $table->string('shipping_length')->nullable();
            $table->string('shipping_width')->nullable();
            $table->string('shipping_height')->nullable();
            $table->string('prop_65')->nullable();
            $table->string('vendor_approval_required', 10)->nullable();

            $table->string('caliber')->nullable();
            $table->string('barrel_length')->nullable();
            $table->string('action')->nullable();
            $table->string('finish')->nullable();
            $table->string('grips')->nullable();
            $table->string('hand')->nullable();
            $table->string('type')->nullable();
            $table->string('wt_characteristics')->nullable();

            $table->boolean('status')->default(false)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_main_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('color')->nullable();
            $table->mediumText('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('product_sub_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('main_category_id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('color')->nullable();
            $table->mediumText('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('category_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('color')->nullable();
            $table->mediumText('description')->nullable();
            $table->boolean('is_boomstick_category')->default(false)->nullable();
            $table->boolean('is_enabled_on_menu')->default(false)->nullable();
            $table->boolean('menu_order_no')->default(false)->nullable();
            $table->boolean('grid_size')->default(3)->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('category_group_has_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_group_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('category_type')->nullable()->comment('main or sub');
            $table->boolean('is_boomstick_category')->default(false)->nullable();
            $table->timestamps();
        });

        Schema::create('product_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('product_id')->nullable();
            $table->string('email')->nullable();
            $table->boolean('store_type')->default(false)->nullable()->comment('0-Boomstick, 1-RSR');
            $table->boolean('status')->default(false)->nullable()->comment('0-Mail didn\'t send, 1-Mail sent');;
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_has_related_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->nullable();
            $table->string('rsr_product_id')->nullable();
            $table->unsignedInteger('related_product_id')->nullable();
            $table->timestamps();
        });

        Schema::create('rsr_product_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_id')->nullable();
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->unsignedInteger('order')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        Schema::create('rsr_main_category_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('department_id')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->boolean('is_enabled_accessories')->default(true)->nullable();
            $table->boolean('is_enabled_action')->default(true)->nullable();
            $table->boolean('is_enabled_type_of_barrel')->default(true)->nullable();
            $table->boolean('is_enabled_barrel_length')->default(true)->nullable();
            $table->boolean('is_enabled_catalog_code')->default(true)->nullable();
            $table->boolean('is_enabled_chamber')->default(true)->nullable();
            $table->boolean('is_enabled_chokes')->default(true)->nullable();
            $table->boolean('is_enabled_condition')->default(true)->nullable();
            $table->boolean('is_enabled_capacity')->default(true)->nullable();
            $table->boolean('is_enabled_description')->default(true)->nullable();
            $table->boolean('is_enabled_dram')->default(true)->nullable();
            $table->boolean('is_enabled_edge')->default(true)->nullable();
            $table->boolean('is_enabled_firing_casing')->default(true)->nullable();
            $table->boolean('is_enabled_finish')->default(true)->nullable();
            $table->boolean('is_enabled_fit')->default(true)->nullable();
            $table->boolean('is_enabled_fit_2')->default(true)->nullable();
            $table->boolean('is_enabled_feet_per_second')->default(true)->nullable();
            $table->boolean('is_enabled_frame')->default(true)->nullable();
            $table->boolean('is_enabled_caliber')->default(true)->nullable();
            $table->boolean('is_enabled_caliber_2')->default(true)->nullable();
            $table->boolean('is_enabled_grain_weight')->default(true)->nullable();
            $table->boolean('is_enabled_grips')->default(true)->nullable();
            $table->boolean('is_enabled_hand')->default(true)->nullable();
            $table->boolean('is_enabled_manufacturer')->default(true)->nullable();
            $table->boolean('is_enabled_manufacturer_part')->default(true)->nullable();
            $table->boolean('is_enabled_manufacturer_weight')->default(true)->nullable();
            $table->boolean('is_enabled_moa')->default(true)->nullable();
            $table->boolean('is_enabled_model')->default(true)->nullable();
            $table->boolean('is_enabled_model_1')->default(true)->nullable();
            $table->boolean('is_enabled_new_stock')->default(true)->nullable();
            $table->boolean('is_enabled_nsn')->default(true)->nullable()->comment('National Stock #');
            $table->boolean('is_enabled_objective')->default(true)->nullable();
            $table->boolean('is_enabled_ounce_of_shot')->default(true)->nullable();
            $table->boolean('is_enabled_packaging')->default(true)->nullable();
            $table->boolean('is_enabled_power')->default(true)->nullable();
            $table->boolean('is_enabled_reticle')->default(true)->nullable();
            $table->boolean('is_enabled_safety')->default(true)->nullable();
            $table->boolean('is_enabled_sights')->default(true)->nullable();
            $table->boolean('is_enabled_size')->default(true)->nullable();
            $table->boolean('is_enabled_type')->default(true)->nullable();
            $table->boolean('is_enabled_units_per_box')->default(true)->nullable();
            $table->boolean('is_enabled_units_per_case')->default(true)->nullable();
            $table->boolean('is_enabled_wt_characteristics')->default(true)->nullable();
            $table->boolean('is_enabled_sub_category')->default(true)->nullable();
            $table->boolean('is_enabled_diameter')->default(true)->nullable();
            $table->boolean('is_enabled_color')->default(true)->nullable();
            $table->boolean('is_enabled_material')->default(true)->nullable();
            $table->boolean('is_enabled_stock')->default(true)->nullable();
            $table->boolean('is_enabled_lens_color')->default(true)->nullable();
            $table->boolean('is_enabled_handle_color')->default(true)->nullable();
            $table->boolean('status')->default(true)->nullable();
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
        Schema::dropIfExists('rsr_main_category_attributes');
        Schema::dropIfExists('rsr_product_photos');
        Schema::dropIfExists('product_has_related_products');
        Schema::dropIfExists('product_notifications');
        Schema::dropIfExists('category_group_has_categories');
        Schema::dropIfExists('category_groups');
        Schema::dropIfExists('product_sub_categories');
        Schema::dropIfExists('product_main_categories');
        Schema::dropIfExists('products');
    }
}
