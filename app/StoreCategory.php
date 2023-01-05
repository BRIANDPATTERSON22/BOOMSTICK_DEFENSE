<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreCategory extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];

	protected $table = 'store_categories';
	protected $fillable = ['title', 'description', 'slug', 'image', 'status'];

	public function storesData()
	{
	    return $this->hasMany('App\Store', 'store_category_id');
	}

	// public function storeSingleData()
	// {
	//     return $this->belongsTo('App\Store', 'store_category_id');
	// }
}