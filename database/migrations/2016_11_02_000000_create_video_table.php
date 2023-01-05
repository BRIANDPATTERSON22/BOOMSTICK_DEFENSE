<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoTable extends Migration
{
    public function up()
    {
        Schema::create('videos_album', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->mediumText('description')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('videos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('album_id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('video')->nullable();
            $table->string('type', 40)->nullable();
            $table->string('code', 100)->nullable();
            $table->longText('content')->nullable();
            $table->unsignedInteger('user_id');
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('videos');
        Schema::drop('videos_album');
    }
}