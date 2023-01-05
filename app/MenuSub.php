<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class MenuSub extends Authenticatable
{
    protected $table = 'menus_sub';
    protected $fillable = ['menu_id', 'title', 'url', 'order'];
}
