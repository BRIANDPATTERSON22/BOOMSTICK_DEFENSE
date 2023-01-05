<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomerTypeMap extends Authenticatable
{
    protected $table = 'customers_type_map';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function members()
    {
        return $this->hasMany('App\Member', 'type_map_id');
    }

    public function guardian()
    {
        return $this->hasOne('App\Guardian', 'type_map_id');
    }

    public function organization()
    {
        return $this->hasOne('App\Organization', 'type_map_id');
    }
}