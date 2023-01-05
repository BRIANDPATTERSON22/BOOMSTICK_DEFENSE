<?php namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class CategoryGroup extends Authenticatable
{
    protected $table = 'category_groups';
    protected $fillable = ['title', 'slug', 'image', 'color', 'description', 'is_enabled_on_menu', 'menu_order_no', 'status', 'is_boomstick_category'];

    public function have_main_categories()
    {
        return $this->hasMany('App\CategoryGroupHasCategories', 'category_group_id')->where('is_boomstick_category', 1);
    }

    public function have_rsr_main_categories()
    {
        return $this->hasMany('App\CategoryGroupHasCategories', 'category_group_id')->where('is_boomstick_category', 0);
    }

    public function get_is_enabled_on_menu()
    {
        return $this->is_enabled_on_menu == 1 ? '<span class="label label-success">Enabled</span>' : '<span class="label label-danger">Disabled</span>';
    }
}
