<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('type');
            $table->tinyInteger('order');
            $table->string('title');
            $table->string('url');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        Schema::create('menus_sub', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('menu_id');
            $table->tinyInteger('order');
            $table->string('title');
            $table->string('url');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('menus');
    }
}
