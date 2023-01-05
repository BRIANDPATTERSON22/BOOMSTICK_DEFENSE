<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoTable extends Migration
{
    public function up()
    {
        Schema::create('photos_album', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->longText('content')->nullable();
            $table->unsignedInteger('user_id');
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('photos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('album_id');
            $table->string('image');
            $table->string('title')->nullable();
            $table->mediumText('description')->nullable();
            $table->unsignedInteger('order');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('photos');
        Schema::drop('photos_album');
    }
}
