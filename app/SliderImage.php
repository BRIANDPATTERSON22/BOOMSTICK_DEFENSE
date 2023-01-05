<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SliderImage extends Authenticatable
{
    protected $table = 'slider_images';
    protected $fillable = ['title', 'description', 'link1', 'link2', 'order'];
}
