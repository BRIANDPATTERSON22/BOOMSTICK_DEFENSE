<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactTable extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone_no', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('subject')->nullable();
            $table->tinyInteger('contact_reason')->nullable();
            $table->string('order_no')->nullable();
            $table->longText('inquiry')->nullable();
            $table->boolean('is_viewed')->default(false)->nullable();;
            $table->boolean('status')->default(false)->nullable();;
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('contacts');
    }
}
