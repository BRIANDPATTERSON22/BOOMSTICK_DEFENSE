<?php namespace App\Http\Controllers\Site;

use App\Page;
use App\Http\Controllers\Controller;

class StaticPageController extends Controller
{
    public function __construct(Page $page)
    {
        $this->module = "page";
        $this->data =$page;
        $this->middleware('guest');
    }

    public function get_single($slug)
    {
        $module = $this->module;

        $singleData = $this->data->where('slug', $slug)->where('status', 1)->first();

        if($singleData){
            return view('site.'.$module.'.static', compact('singleData'));
        }
        else{
            return view('site.errors.404');
        }
    }
}