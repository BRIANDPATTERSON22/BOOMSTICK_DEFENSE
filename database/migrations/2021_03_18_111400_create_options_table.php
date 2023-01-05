<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('title');
            $table->mediumText('description')->nullable();
            $table->mediumText('keywords')->nullable();

            $table->string('email')->nullable();
            $table->string('phone_no', 30)->nullable();
            $table->string('mobile_no', 30)->nullable();
            $table->string('whatsapp_no', 30)->nullable();
            $table->string('viber_no', 30)->nullable();
            $table->string('fax_no', 20)->nullable();
            $table->mediumText('address')->nullable();
            $table->mediumText('address_1')->nullable();
            $table->mediumText('branch')->nullable();
            $table->mediumText('branch_1')->nullable();
            $table->mediumText('map_iframe')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->string('favicon')->nullable();
            $table->string('logo')->nullable();
            $table->string('logo_white')->nullable();
            $table->string('logo_black')->nullable();
            $table->string('bg_breadcrumb')->nullable();

            $table->string('skype_id')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('pinterest')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('google_analytics')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_website')->nullable();

            $table->string('currency', 50)->nullable();
            $table->string('currency_code', 10)->nullable();
            $table->string('currency_symbol', 10)->nullable();

            $table->boolean('is_sidebar_collapsed')->default(false);
            $table->string('sidebar_skin_color', 50)->nullable();
            $table->string('theme_style_sheet', 50)->nullable();
            $table->longText('custom_css_style')->nullable();
            $table->text('theme_settings')->nullable();
            
            $table->mediumText('disclaimer_agreement_message')->nullable();
            $table->mediumText('warning_message')->nullable();
            $table->decimal('retail_price_percentage', 5,2)->nullable();

            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('options');
    }
}
