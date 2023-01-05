<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->mediumText('summary')->nullable();
            $table->longText('content')->nullable();
            $table->unsignedInteger('user_id');
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('pages');
    }
}
