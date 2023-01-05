<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryGroupHasCategories extends Model
{
	// use SoftDeletes;
	protected $dates = ['deleted_at'];

	protected $table = 'category_group_has_categories';
	protected $fillable = ['category_id', 'category_group_id', 'category_type', 'is_boomstick_category'];

	public function has_main_category()
	{
	    return $this->belongsTo('App\ProductCategory', 'category_id');
	}

	public function has_rsr_main_category()
	{
	    return $this->belongsTo('App\RsrMainCategory', 'category_id', 'department_id');
	}
}
