<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class VideoAlbum extends Authenticatable
{
    protected $table = 'videos_album';
    protected $fillable = ['title', 'description', 'slug'];

    public function video()
    {
        return $this->hasMany('App\Video', 'album_id');
    }
}
