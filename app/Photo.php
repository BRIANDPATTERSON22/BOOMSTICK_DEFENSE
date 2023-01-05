<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Photo extends Authenticatable
{
    protected $table = 'photos';
    protected $fillable = ['album_id', 'title', 'description'];

    public function photoAlbum()
    {
        return $this->belongsTo('App\PhotoAlbum', 'album_id');
    }
}
