<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Upload extends Authenticatable
{
    protected $table = 'uploads';
    protected $fillable = ['image', 'title'];
}
