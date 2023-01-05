<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SectionProduct extends Authenticatable
{
    protected $table = 'section_product';
    protected $fillable = ['section_title_word_1','section_title_word_1_color','section_title_word_2','column_title_1','column_title_2', 'column_title_3','url_column_1','	url_column_2', 'url_column_3','offer_ended_at','is_active_column_1','image'];
}
