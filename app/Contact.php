<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'contacts';
    protected $fillable = ['first_name', 'last_name', 'phone_no', 'email', 'subject', 'contact_reason', 'order_no', 'inquiry', 'is_viewed'];
    
    public function get_conatct_reason()
    {
        return $this->contact_reason ? config('default.contactReason')[$this->contact_reason] ?? '...' : "---";
    }

    public function getTableColumns()
    {
        $results = $this->getConnection()->select(
            (new \Illuminate\Database\Schema\Grammars\MySqlGrammar)->compileColumnListing()
                .' order by ordinal_position',
            [$this->getConnection()->getDatabaseName(), $this->getTable()]
        );
        return $this->getConnection()->getPostProcessor()->processColumnListing($results);
    }
}
