<?php namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Block extends Authenticatable
{
    protected $table = 'blocks';
    protected $fillable = ['title', 'slug', 'content'];
}
