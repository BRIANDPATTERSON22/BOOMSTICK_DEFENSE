<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'pages';
    protected $fillable = ['title', 'title_display', 'menu_title', 'image', 'summary', 'summary_display', 'content', 'content_display', 'slug'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
