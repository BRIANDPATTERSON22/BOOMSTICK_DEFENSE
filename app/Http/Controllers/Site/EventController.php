<?php

namespace App\Http\Controllers\Site;

use App\Event;
use App\Page;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function __construct(Page $page, Event $event)
    {
        $this->module = "event";
        $this->page = $page;
        $this->data = $event;
        $this->middleware('guest');
    }

    public function get_all()
    {
        $module = $this->module;
        $page = $this->page->where('slug', 'like', '%'.$module.'%')->where('status', 1)->first();

        if($page) {
            $allData = $this->data->where('status', 1)->orderBy('id', 'DESC')->paginate(25);
        }
        else{
            return view('site.errors.404');
        }

        return view('site.'.$module.'.index', compact('allData', 'page'));
    }

    public function get_single($id)
    {
        $module = $this->module;
        $page = $this->page->where('slug', 'like', '%'.$module.'%')->where('status', 1)->first();

        $singleData = $this->data->find($id);
        $otherData = $this->data->where('id', '!=', $id)->where('status', 1)->orderBy('id', 'DESC')->limit(10)->get();

        return view('site.'.$module.'.single', compact('page', 'singleData', 'otherData'));
    }
}