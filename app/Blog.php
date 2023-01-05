<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'blogs';
    protected $fillable = ['category_id', 'album_id', 'title', 'slug', 'display', 'image',  'video',  'audio', 'summary', 'content', 'link'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo('App\BlogCategory', 'category_id');
    }

    public function gallery()
    {
        return $this->belongsTo('App\PhotoAlbum', 'album_id');
    }
}
