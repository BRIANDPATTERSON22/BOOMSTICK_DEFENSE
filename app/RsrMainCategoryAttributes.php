<?php namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class RsrMainCategoryAttributes extends Authenticatable
{
    protected $table = 'rsr_main_category_attributes';
    // protected $fillable = ['department_id', 'category_id'];
    protected $guarded = [];

    public function have_rsr_main_category()
    {
        return $this->belongsTo('App\RsrMainCategory', 'department_id', 'department_id');
    }
}
