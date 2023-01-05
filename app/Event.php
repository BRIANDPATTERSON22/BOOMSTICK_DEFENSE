<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'events';
    protected $fillable = ['title', 'slug', 'display', 'image', 'venue', 'date', 'time', 'summary', 'content'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}