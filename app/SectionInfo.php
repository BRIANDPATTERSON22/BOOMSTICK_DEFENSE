<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SectionInfo extends Authenticatable
{
    protected $table = 'section_info';
    protected $fillable = ['title_1','description_1', 'url_1', 'bg_color_1', 'title_2', 'description_2', 'url_2','bg_color_2', 'title_3', 'description_3', 'url_3','bg_color_3'];
}
