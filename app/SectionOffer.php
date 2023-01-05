<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SectionOffer extends Authenticatable
{
    protected $table = 'section_offer';
    protected $fillable = ['title','title_2','description','description_2','ad_word', 'offer_image','offer_image_2','title_bgc', 'url','offer_ended_at'];
}
