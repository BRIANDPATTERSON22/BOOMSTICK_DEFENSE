<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ProductPhoto extends Authenticatable
{
    protected $table = 'products_photo';
    protected $fillable = ['title', 'order', 'image'];
}
