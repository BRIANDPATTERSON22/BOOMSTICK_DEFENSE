<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class RsrProductPhoto extends Authenticatable
{
    protected $table = 'rsr_product_photos';
    protected $fillable = ['product_id', 'image', 'title', 'order', 'status'];
}
