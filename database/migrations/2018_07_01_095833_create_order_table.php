<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 50)->unique();
            $table->string('order_no', 40)->nullable();
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('shipping_id')->nullable();
            $table->unsignedInteger('payment_id')->nullable();
            $table->unsignedInteger('coupon_id')->nullable();
            $table->mediumText('note', 20)->nullable();
            $table->mediumText('rejection_message', 20)->nullable();

            $table->decimal('sub_total', 10,2);
            $table->decimal('shipping_amount', 10,2);
            $table->decimal('transaction_amount', 10,2);
            $table->decimal('coupon_amount', 10,2);
            $table->decimal('tax_amount', 10,2);
            $table->decimal('vat_amount', 10,2);
            $table->decimal('grand_total', 10,2);

            $table->boolean('is_same_as_billing')->default(false)->nullable();
            $table->string('billing_address')->nullable();
            $table->unsignedInteger('billing_country_id')->nullable();
            $table->string('billing_city', 100)->nullable();
            $table->string('billing_state', 100)->nullable();
            $table->string('billing_postal_code', 100)->nullable();
            $table->string('delivery_address')->nullable();
            $table->unsignedInteger('delivery_country_id')->nullable();
            $table->string('delivery_city', 100)->nullable();
            $table->string('delivery_state', 100)->nullable();
            $table->string('delivery_postal_code', 100)->nullable();

            $table->boolean('checkout_type')->default(false)->nullable();
            $table->boolean('order_status')->default(false)->nullable();
            $table->boolean('payment_status')->default(false)->nullable();
            $table->boolean('shipping_status')->default(false)->nullable();
            $table->boolean('delivery_status')->default(false)->nullable();
            $table->string('timezone_identifier')->nullable();
            $table->dateTime('dispatched_at')->nullable();
            $table->dateTime('delivery_date')->nullable();
            $table->dateTime('pickup_date')->nullable();

            $table->string('paypal_payment_id')->nullable();
            $table->string('paypal_payer_id')->nullable();
            $table->string('shipping_service_id')->nullable();
            $table->string('shipping_service_name')->nullable();

            $table->string('ip', 100)->nullable();
            $table->boolean('is_viewed')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('orders_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->string('upc')->nullable();
            $table->string('image')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->decimal('price', 10,2);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->decimal('amount', 10,2)->nullable();
            $table->string('time')->nullable();
            $table->mediumText('description')->nullable();
            $table->string('image')->nullable();
            $table->string('color')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('payment_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('email')->nullable();
            $table->string('mode')->nullable();
            $table->string('key_1')->nullable();
            $table->string('key_2')->nullable();
            $table->string('key_3')->nullable();
            $table->mediumText('description')->nullable();
            $table->mediumText('content')->nullable();
            $table->string('image')->nullable();
            $table->string('color')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('wish_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->tinyInteger('product_id');
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
        Schema::dropIfExists('wish_lists');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('shipping_methods');
        Schema::dropIfExists('orders_items');
        Schema::dropIfExists('orders');
    }
}
