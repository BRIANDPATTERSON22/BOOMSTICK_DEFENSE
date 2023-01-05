<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreManagerHasStore extends Model
{
    protected $table = 'store_manager_has_stores';
    protected $fillable = ['store_manager_id', 'store_id',];

    public function store()
    {
        return $this->belongsTo('App\Store', 'store_id', 'store_id');
    }
}
