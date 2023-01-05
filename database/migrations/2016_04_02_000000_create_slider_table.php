<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSliderTable extends Migration
{
    public function up()
    {
        Schema::create('slider', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('title1')->nullable();
            $table->string('title2')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('type', 10);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        Schema::create('slider_images', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('slider_id');
            $table->foreign('slider_id')->references('id')->on('slider')->onDelete('cascade');
            $table->string('image');
            $table->string('title')->nullable();
            $table->string('link1')->nullable();
            $table->string('link2')->nullable();
            $table->mediumText('description')->nullable();
            $table->unsignedInteger('order');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('slider_images');
        Schema::drop('slider');
    }
}
