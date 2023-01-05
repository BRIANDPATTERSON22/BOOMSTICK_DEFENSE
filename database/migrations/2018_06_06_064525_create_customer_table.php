<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 50)->unique();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('role_id')->nullable();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('cover_image')->nullable();
            $table->date('dob')->nullable();
            $table->string('phone_no', 20)->nullable();
            $table->string('mobile_no', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('email')->nullable();
            $table->mediumText('description')->nullable();

            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->unsignedInteger('country_id')->nullable();

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
            $table->boolean('is_same_as_billing')->default(false)->nullable();
            
            $table->tinyInteger('registration_type')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
}
