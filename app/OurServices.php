<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OurServices extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'our_services';
    protected $fillable = ['service_name', 'image', 'description' ,'status'];

}
