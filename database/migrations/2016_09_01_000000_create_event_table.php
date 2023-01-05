<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('venue')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
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
        Schema::drop('events');
    }
}
