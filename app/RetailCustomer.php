<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RetailCustomer extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'retail_customers';
    protected $fillable = ['first_name', 'last_name', 'address1', 'address2', 'city', 'state', 'country_id', 'dob', 'postal_code', 'phone', 'mobile', 'email', 'fax'];

     public function user()
     {
         return $this->belongsTo('App\User', 'user_id');
     }

     public function country()
     {
         return $this->belongsTo('App\Country', 'country_id');
     }
}