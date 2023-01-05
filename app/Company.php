<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'companies';
    protected $fillable = ['user_id', 'title', 'short_description' ,'content', 'slug', 'image', 'url', 'status'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
