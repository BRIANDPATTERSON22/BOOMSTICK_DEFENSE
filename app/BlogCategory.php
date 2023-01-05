<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'blog_categories';
    protected $fillable = ['user_id', 'title', 'slug', 'image', 'description'];

    public function blog()
    {
        return $this->hasMany('App\Blog', 'category_id');
    }
}
