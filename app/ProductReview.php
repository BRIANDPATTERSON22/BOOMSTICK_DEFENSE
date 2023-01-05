<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReview extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'product_reviews';
    protected $fillable = ['name', 'email', 'phone', 'review_title', 'review', 'star'];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
