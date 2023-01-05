<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Slider extends Authenticatable
{
    protected $table = 'slider';
    protected $fillable = ['title', 'title1', 'title2', 'image', 'video', 'type'];
}
