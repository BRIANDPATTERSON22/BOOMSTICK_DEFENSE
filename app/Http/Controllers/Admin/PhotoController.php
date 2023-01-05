<?php namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use DateTime;
use App\Photo;
use App\PhotoAlbum;
use App\Http\Requests\Admin\PhotoRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PhotoController extends Controller {

    public function __construct(Photo $photo, PhotoAlbum $photoAlbum)
    {
        $this->module = "photo";
        $this->data = $photo;
        $this->album = $photoAlbum;

        $this->option = Cache::get('optionCache');
        $this->middleware('auth');
    }

    public function get_index()
    {
        $module = $this->module;
        $deleteCount = $this->album->onlyTrashed()->count();

        $year = date('Y');
        $allData = $this->album->select('photos_album.*', DB::raw('COUNT(photos_album.id) AS number_of_image'))
            ->join('photos', 'photos.album_id', '=', 'photos_album.id')
            ->where('photos_album.created_at', 'like', $year.'%')
            ->groupBy('photos_album.id')
            ->orderBy('photos_album.id', 'DESC')
            ->get();

        return view('admin.'.$module.'.index', compact('allData', 'module', 'deleteCount', 'year'));
    }

    public function get_archive($year)
    {
        $module = $this->module;
        $deleteCount = $this->album->onlyTrashed()->count();

        $allData = $this->album->select('photos_album.*', DB::raw('COUNT(photos_album.id) AS number_of_image'))
            ->join('photos', 'photos.album_id', '=', 'photos_album.id')
            ->where('photos_album.created_at', 'like', $year.'%')
            ->groupBy('photos_album.id')
            ->orderBy('photos_album.id', 'DESC')
            ->get();

        return view('admin.'.$module.'.index', compact('allData', 'module', 'deleteCount', 'year'));
    }

    public function get_trash()
    {
        $module = $this->module;
        $allData = $this->album->onlyTrashed()->get();

        return view('admin.'.$module.'.index', compact('allData', 'module'));
    }

    public function get_add()
    {
        $module = $this->module;

        $singleData = $this->album;
        $singleData->photo = null;

        return view('admin.'.$module.'.add_edit',compact('singleData', 'module'));
    }

    public function post_add(PhotoRequest $request)
    {
        $module = $this->module;
        $files = Input::file('photo.image');
        if(!$files) {
            return redirect()->back()->with('error', 'Please select images');
        }

        //Photo album save function
        $this->album->fill($request->get('photoAlbum'));
        $this->album->user_id = Auth::id();

        $slug = str_slug($request->photoAlbum['title']);
        $existingSlugs = $this->album->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->album->slug =$slug.$existingSlugs : $this->album->slug = $slug;

        $this->album->status = 1;
        $this->album->save();
        $albumId = $this->album->id;

        //Image upload function.
        $images = null;
        $i = 0;
        foreach($files as $file) {
            $i++;
            Image::make($file)->widen(1024)->save($file);
            $filename = $i.'_'.time().'.'.$file->getClientOriginalExtension();
            $filepath = $module.'s/'.$albumId.'/'.$filename;
            $upload_success = Storage::put($filepath, file_get_contents($file), 'public');
            if($upload_success) {
                $images[] = [
                    'order' => $i,
                    'image' => $filename,
                    'album_id' => $albumId,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ];
            }
        }
        $this->data->insert($images);

        $sessionMsg = $this->album->title;
        return redirect('admin/'.$module.'/'.$albumId.'/view')->with('success', 'Data '.$sessionMsg.' has been created');
    }

    public function get_edit($id)
    {
        $module = $this->module;

        $singleData = $this->album;
        $singleData->photoAlbum = $this->album->find($id);
        $singleData->photo = $this->data->where('album_id', $id)->orderBy('order', 'ASC')->get();

        return view('admin.'.$module.'.add_edit',compact('singleData', 'module'));
    }

    public function post_edit(PhotoRequest $request, $id)
    {
        $module = $this->module;
        $photos = $this->data->where('album_id', $id)->orderBy('order', 'DESC')->get();

        $this->album = $this->album->find($id);
        $this->album->fill($request->get('photoAlbum'));
        $this->album->slug = str_slug($request->photoAlbum['slug']);
        $request->status == 1 ? $this->album->status = 1 : $this->album->status = 0;
        $this->album->save();

        //Image upload function
        $i = $photos[0]->order;
        $files = Input::file('photo.image');
        if(count($files)>0) {
            foreach ($files as $file) {
                $i++;
                Image::make($file)->widen(1024)->save($file);
                $filename = $i . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filepath = $module . 's/' . $id . '/' . $filename;
                $upload_success = Storage::put($filepath, file_get_contents($file), 'public');
                if ($upload_success) {
                    $images[] = [
                        'order' => $i,
                        'image' => $filename,
                        'album_id' => $id,
                        'created_at' => new DateTime,
                        'updated_at' => new DateTime,
                    ];
                }
            }
            $this->data->insert($images);
        }

        $sessionMsg = $this->album->title;
        return redirect('admin/'.$module.'/'.$id.'/view')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function photo_update(Request $request, $id)
    {
        $this->data = $this->data->find($id);
        $this->data->fill($request->all());
        $this->data->save();

        return redirect('admin/photo/'.$this->data->album_id.'/edit#slide')->with('success', 'Data has been updated successfully.');
    }

    public function photo_delete($id)
    {
        $module = $this->module;
        $data = $this->data->find($id);

        if($data->delete()) {
            Storage::delete($module.'s/'.$data->album_id.'/'.$data->image);
            return redirect()->back()->with('success', 'Data has been deleted successfully.');
        }
        else {
            return redirect()->back()->with('error', 'Data has not been deleted.');
        }
    }

    public function get_view($id)
    {
        $module = $this->module;

        $album = $this->album->find($id);
        $photos = $this->data->where('album_id', $id)->orderBy('order', 'ASC')->get();

        return view('admin.'.$module.'.view',compact('album', 'photos', 'module'));
    }

    public function soft_delete($id)
    {
        if($this->album->find($id)->delete()) {
            return redirect()->back()->with('success', 'Your data has been moved to trash');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been moved to trash.');
        }
    }

    public function get_restore($id)
    {
        if($this->album->where('id', $id)->withTrashed()->first()->restore()) {
            return redirect()->back()->with('success', 'Your data has been restored.');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been restored.');
        }
    }

    public function force_delete($id)
    {
        $module = $this->module;

        if($this->album->where('id', $id)->withTrashed()->first()->forceDelete()) {
            Storage::deleteDirectory($module.'s/'.$id);
            return redirect()->back()->with('success', 'Your data has been permanently deleted');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been permanently deleted.');
        }
    }
}