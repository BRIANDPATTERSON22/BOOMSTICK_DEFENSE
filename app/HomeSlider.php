<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeSlider extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'home_slider';
    protected $fillable = ['title', 'title_ta', 'main_title', 'main_title_ta','sub_title', 'sub_title_ta','image', 'description', 'description_ta','link', 'time', 'summary', 'summary_ta', 'content', 'content_ta'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}