<?php namespace App;

use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    protected $table = 'users';
    protected $fillable = ['name', 'email','image'];
    protected $hidden = ['password', 'remember_token',];

    public function customer()
    {
        return $this->hasOne('App\Customer', 'user_id');
    }

    public function storeManager()
    {
        return $this->hasOne('App\StoreManager', 'user_id');
    }

    public function salesPerson()
    {
        return $this->hasOne('App\SalesPerson', 'user_id');
    }
}