<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment_methods';
    protected $fillable = ['title', 'email', 'description', 'content', 'status'];
}
