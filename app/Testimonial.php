<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'testimonial';
    protected $fillable = ['title', 'video', 'image', 'summary', 'content', 'slug', 'album_id', 'first_name', 'last_name', 'job', 'review'];
}
