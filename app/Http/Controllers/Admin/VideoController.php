<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\Video;
use App\VideoAlbum;
use App\Http\Requests\Admin\VideoRequest;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    public function __construct(Video $video, VideoAlbum $album)
    {
        $this->module = "video";
        $this->data = $video;
        $this->album = $album;

        $this->middleware('auth');
    }

    public function get_index()
    {
        $module = $this->module;
        $deleteCount = $this->data->onlyTrashed()->count();

        $year = date('Y');
        $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->with('album')->with('user')->get();

        return view('admin.'.$module.'.index', compact('allData', 'module', 'deleteCount', 'year'));
    }

    public function get_archive($year)
    {
        $module = $this->module;
        $deleteCount = $this->data->onlyTrashed()->count();

        $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->with('album')->with('user')->get();

        return view('admin.'.$module.'.index', compact('allData', 'module', 'deleteCount', 'year'));
    }

    public function get_trash()
    {
        $module = $this->module;
        $allData = $this->data->onlyTrashed()->get();

        return view('admin.'.$module.'.index', compact('allData', 'module'));
    }

    public function get_add()
    {
        $module = $this->module;

        $singleData = $this->data;
        $albums = $this->album->where('status', 1)->pluck('title', 'id');

        return view('admin.'.$module.'.add_edit', compact('singleData', 'albums', 'module'));
    }

    public function post_add(VideoRequest $request)
    {
        $module = $this->module;

        $this->data->fill($request->all());
        $this->data->user_id = Auth::id();

        $slug = str_slug($request->title);
        $existingSlugs = $this->data->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->data->slug =$slug.$existingSlugs : $this->data->slug = $slug;

        //External sources
        if($request->source) {
            $url = $request->source;
            if(stripos($url, "youtube") !== false) {
                parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
                $this->data->type = "youtube";
                $this->data->code = $my_array_of_vars['v'];
            }elseif(stripos($url, "vimeo") !== false) {
                $this->data->type = "vimeo";
                $segments = explode('/',$url);
                $this->data->code = end($segments);
            }elseif(stripos($url, "facebook") !== false) {
                $this->data->type = "facebook";
                $this->data->code = $url;
            }else{
                return redirect()->back()->with('error', 'Not a supported source URL format');
            }
        }

        $this->data->status = 1;
        $this->data->save();

        $dataId = $this->data->id;
        $sessionMsg = $this->data->title;
        return redirect('admin/'.$module.'/'.$dataId.'/view')->with('success', 'Data '.$sessionMsg.' has been created');
    }

    public function get_edit($id)
    {
        $module = $this->module;

        $singleData = $this->data->find($id);
        $albums = $this->album->where('status', 1)->pluck('title', 'id');

        return view('admin.'.$module.'.add_edit',compact('singleData', 'albums', 'module'));
    }

    public function post_edit(VideoRequest $request, $id)
    {
        $module = $this->module;

        $this->data = $this->data->find($id);
        $this->data->fill($request->all());

        //External sources
        if($request->source) {
            $url = $request->source;
            if(stripos($url, "youtube") !== false) {
                parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
                $this->data->type = "youtube";
                $this->data->code = $my_array_of_vars['v'];
            }elseif(stripos($url, "vimeo") !== false) {
                $this->data->type = "vimeo";
                $segments = explode('/',$url);
                $this->data->code = end($segments);
            }elseif(stripos($url, "facebook") !== false) {
                $this->data->type = "facebook";
                $this->data->code = $url;
            }else{
                return redirect()->back()->with('error', 'Not a supported source URL format');
            }
        }

        $request->status == 1 ? $this->data->status = 1 : $this->data->status = 0;
        $this->data->save();

        $sessionMsg = $this->data->title;
        return redirect('admin/'.$module.'/'.$id.'/view')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function get_view($id)
    {
        $module = $this->module;

        $singleData = $this->data->find($id);

        return view('admin.'.$module.'.view',compact('singleData', 'module'));
    }

    public function soft_delete($id)
    {
        if($this->data->find($id)->delete()) {
            return redirect()->back()->with('success', 'Your data has been moved to trash');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been moved to trash.');
        }
    }

    public function get_restore($id)
    {
        if($this->data->where('id', $id)->withTrashed()->first()->restore()) {
            return redirect()->back()->with('success', 'Your data has been restored.');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been restored.');
        }
    }

    public function force_delete($id)
    {
        if($this->data->where('id', $id)->withTrashed()->first()->forceDelete()) {
            return redirect()->back()->with('success', 'Your data has been permanently deleted');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been permanently deleted.');
        }
    }
}