<?php namespace App\Http\Controllers\Admin;

use App\Video;
use App\VideoAlbum;
use App\Http\Requests\Admin\VideoAlbumRequest;
use App\Http\Controllers\Controller;

class VideoAlbumController extends Controller {

    public function __construct(Video $video, VideoAlbum $album)
    {
        $this->module = "video";
        $this->data = $video;
        $this->album = $album;

        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $module = $this->module;

        $allData = $this->album->orderBy('id', 'DESC')->get();

        if($id) {
            $singleData = $this->album->find($id);
        }
        else {
            $singleData = $this->album;
        }

        return view('admin.'.$module.'.album', compact('allData', 'singleData', 'module'));
    }

    public function post_add(VideoAlbumRequest $request)
    {
        $module = $this->module;

        $this->album->fill($request->all());

        $slug = str_slug($request->title);
        $existingSlugs = $this->album->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->album->slug =$slug.$existingSlugs : $this->album->slug = $slug;

        $this->album->status = 1;
        $this->album->save();

        $sessionMsg = $this->album->title;
        return redirect('admin/'.$module.'s/album')->with('success', 'Data '.$sessionMsg.' data has been created');
    }

    public function post_edit(VideoAlbumRequest $request, $id)
    {
        $module = $this->module;

        $this->album = $this->album->find($id);
        $this->album->fill($request->all());
        $this->album->slug = str_slug($request->slug);
        $request->status == 1 ? $this->album->status = 1 : $this->album->status = 0;
        $this->album->save();

        $sessionMsg = $this->album->title;
        return redirect('admin/'.$module.'s/album')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function get_delete($id)
    {
        $module = $this->module;

        $catData = $this->data->where('album_id', $id)->get();
        if(count($catData)>0) {
            return redirect('admin/'.$module.'s/album')->with('error', 'Please delete corresponding data before delete the data.');
        }
        else {
            $this->album->find($id)->delete();
            return redirect('admin/'.$module.'s/album')->with('success', 'Your data has been deleted successfully.');

        }
    }
}