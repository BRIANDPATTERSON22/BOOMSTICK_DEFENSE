<?php namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'colors';
    protected $fillable = ['name', 'slug', 'image', 'description', 'status','color_code'];

    // public function products()
    // {
    //     return $this->hasMany('App\Product', 'color_id');
    // }
}
