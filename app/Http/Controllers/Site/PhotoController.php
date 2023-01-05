<?php

namespace App\Http\Controllers\Site;

use DB;
use App\Page;
use App\PhotoAlbum;
use App\Photo;
use App\Http\Controllers\Controller;

class PhotoController extends Controller
{
    public function __construct(Page $page, Photo $photo, PhotoAlbum $album)
    {
        $this->module = "photo";
        $this->page = $page;
        $this->data = $photo;
        $this->album = $album;
        $this->middleware('guest');
    }

    public function get_all()
    {
        $module = $this->module;
        $page = $this->page->where('slug', 'like', '%'.$module.'%')->where('status', 1)->first();

        if($page) {
            $allData = $this->album->join('photos', 'photos_album.id', '=', 'photos.album_id')
                ->where('photos_album.status', 1)
                ->select('photos_album.*', 'photos.image', DB::raw('COUNT(photos_album.id) AS number_of_image'))
                ->groupBy('photos.album_id')
                ->orderBy('photos.id', 'DESC')
                ->paginate(20);
        }
        else{
            return view('site.errors.404');
        }

        return view('site.'.$module.'.index', compact('allData'));
    }

    public function get_single($id)
    {
        $module = $this->module;
        $page = $this->page->where('slug', 'like', '%'.$module.'%')->where('status', 1)->first();

        $album = $this->album->find($id);
        $photos = $this->data->where('album_id', $id)->get();

        return view('site.'.$module.'.single', compact('page', 'album', 'photos'));
    }
}