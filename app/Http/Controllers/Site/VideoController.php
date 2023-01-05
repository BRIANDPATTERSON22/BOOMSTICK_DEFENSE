<?php

namespace App\Http\Controllers\Site;

use DB;
use App\Page;
use App\Video;
use App\VideoAlbum;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    public function __construct(Page $page, Video $video, VideoAlbum $album)
    {
        $this->module = "video";
        $this->page = $page;
        $this->data = $video;
        $this->album = $album;
        $this->middleware('guest');
    }

    public function get_all()
    {
        $module = $this->module;
        $page = $this->page->where('slug', 'like', '%'.$module.'%')->where('status', 1)->first();

        if($page) {
            $allData = $this->data->where('status', 1)->orderBy('id', 'DESC')->paginate(20);
        }
        else{
            return view('site.errors.404');
        }

        return view('site.'.$module.'.index', compact('allData'));
    }

    public function get_album($album)
    {
        $module = $this->module;
        $albumData = $this->album->where('slug', $album)->where('status', 1)->first();

        if(isset($albumData)){
            $album_id = $albumData->id;
            $allData = $this->data->where('album_id', $album_id)->where('status', 1)->paginate(20);

            if(count($allData)>0) {
                return view('site.'.$module.'.index', compact('allData'));
            }else{
                return redirect('videos')->with('error', 'No Data Found for '. $album);
            }
        }else{
            return view('site.errors.404');
        }
    }

    public function get_single($album, $id)
    {
        $module = $this->module;
        $page = $this->page->where('slug', 'like', '%'.$module.'%')->where('status', 1)->first();

        $singleData = $this->data->find($id);
        $otherData = $this->data->where('id', '<>', $id)->where('status', 1)->orderBy('id', 'DESC')->get();

        return view('site.'.$module.'.single', compact('page', 'singleData', 'otherData'));
    }
}