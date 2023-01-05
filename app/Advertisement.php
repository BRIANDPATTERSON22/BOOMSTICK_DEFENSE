<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'advertisements';
    protected $fillable = ['display', 'title', 'content', 'image', 'link',  'start_at', 'end_at','is_permanent'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
