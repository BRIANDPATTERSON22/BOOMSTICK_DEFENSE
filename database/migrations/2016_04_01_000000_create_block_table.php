<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockTable extends Migration
{
    public function up()
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->longText('content')->nullable();
            $table->boolean('status');
            $table->boolean('is_admin');
            $table->timestamps();
        });

        Schema::create('uploads', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('image');
            $table->string('title')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('uploads');
        Schema::drop('blocks');
    }
}
