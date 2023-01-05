<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreManager extends Model
{
    protected $table = 'store_managers';
    protected $fillable = ['user_id', 'first_name', 'last_name', 'slug', 'email', 'image','date_of_birth', 'address_1', 'city', 'state', 'postal_code', 'country_id', 'phone_no', 'mobile_no','fax', 'status'];

    public function haveStores()
    {
        return $this->hasMany('App\StoreManagerHasStore', 'store_manager_id');
    }
}
