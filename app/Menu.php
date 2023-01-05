<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Menu extends Authenticatable
{
    protected $table = 'menus';
    protected $fillable = ['title', 'type', 'url', 'order'];

    public function subMenus()
    {
        return $this->hasMany('App\MenuSub', 'menu_id');
    }
}
