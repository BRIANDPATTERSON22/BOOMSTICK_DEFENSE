<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'coupon';
    protected $fillable = ['name', 'coupon_type', 'series_no', 'pin_no', 'count', 'percentage', 'start_date', 'expiry_date', 'use_count'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}