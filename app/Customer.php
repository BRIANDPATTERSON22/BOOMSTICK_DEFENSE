<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'customers';
    protected $fillable = ['uuid', 'user_id', 'role_id', 'first_name', 'last_name', 'slug', 'image', 'cover_image', 'dob', 'phone_no', 'mobile_no', 'fax', 'email', 'description', 'address_1', 'address_2', 'city', 'state', 'postal_code', 'country_id','billing_address','billing_country_id','billing_city','billing_state','billing_postal_code','delivery_address','delivery_country_id','delivery_city','delivery_state','delivery_postal_code', 'is_same_as_billing', 'registration_type'];

     public function user()
     {
         return $this->belongsTo('App\User', 'user_id');
     }

     public function country()
     {
         return $this->belongsTo('App\Country', 'country_id');
     }

     public function billingCountry()
     {
         return $this->belongsTo('App\Country', 'billing_country_id');
     }

     public function deliveryCountry()
     {
         return $this->belongsTo('App\Country', 'delivery_country_id');
     }

     public function hasOrdered()
     {
        return $this->hasMany('App\Order', 'customer_id');
     }

     public function payments()
     {
        return $this->hasMany('App\CustomerPaymentMethod', 'customer_id');
     }
}