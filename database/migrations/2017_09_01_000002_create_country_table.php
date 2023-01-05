<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryTable extends Migration
{
    public function up()
    {
        Schema::create('country', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->char('iso', 2);
            $table->string('name', 80);
            $table->string('nicename', 80);
            $table->char('iso3', 3)->nullable();
            $table->unsignedInteger('numcode')->nullable();
            $table->unsignedInteger('phonecode');
        });
    }

    public function down()
    {
        Schema::drop('country');
    }
}