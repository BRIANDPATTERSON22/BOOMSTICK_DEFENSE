<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'videos';
    protected $fillable = ['album_id', 'title', 'display', 'content', 'url', 'slug'];

    public function album()
    {
        return $this->belongsTo('App\VideoAlbum', 'album_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
