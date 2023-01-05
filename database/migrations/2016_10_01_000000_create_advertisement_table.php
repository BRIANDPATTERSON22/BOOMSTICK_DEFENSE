<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementTable extends Migration
{
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('display')->nullable();
            $table->string('link')->nullable();
            $table->string('image')->nullable();
            $table->longText('content')->nullable();
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->unsignedInteger('user_id');
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('advertisements');
    }
}
