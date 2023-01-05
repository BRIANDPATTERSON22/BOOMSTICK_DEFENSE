<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhotoAlbum extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'photos_album';
    protected $fillable = ['title', 'slug', 'content'];

    public function photo()
    {
        return $this->hasMany('App\Photo', 'album_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
