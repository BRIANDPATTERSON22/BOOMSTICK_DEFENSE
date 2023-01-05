<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesPersonHasStore extends Model
{
    protected $table = 'sales_person_has_stores';
    protected $fillable = ['sales_person_id', 'store_id',];

    public function store()
    {
        return $this->belongsTo('App\Store', 'store_id', 'store_id');
    }

    public function salesPerson()
    {
        return $this->belongsTo('App\SalesPerson', 'sales_person_id');
    }
}
