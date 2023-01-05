<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Blog;
use App\BlogCategory;
use App\PhotoAlbum;
use App\Http\Requests;
use App\Http\Requests\Admin\BlogRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
{
    public function __construct(Blog $blog, BlogCategory $category)
    {
        $this->module = "blog";
        $this->data = $blog;
        $this->category = $category;
        $this->option = Cache::get('optionCache');
        $this->middleware('auth');

        // $this->middleware(function ($request, $next) {
        //     // $this->projects = Auth::user()->projects;
        //     $this->loginUser = Auth::user();
        //     return $next($request);
        // });
    }

    public function index()
    {
        $module = $this->module;
        $deleteCount = $this->data->onlyTrashed()->count();

        if(Auth::user()->hasRole('admin')) {
            $allData = $this->data->orderBy('id', 'DESC')->with('category')->with('user')->paginate(15);
        }else{
            $allData = $this->data->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->with('category')->with('user')->paginate(15);
        }

        return view('admin.'.$module.'.index', compact('allData', 'module', 'deleteCount'));
    }

    public function get_add()
    {
        $module = $this->module;

        $singleData = new Blog();
        $category = $this->category->where('status', 1)->pluck('title', 'id');
        $gallery = PhotoAlbum::where('status', 1)->pluck('title', 'id');

        return view('admin.'.$module.'.add_edit', compact('singleData', 'category', 'gallery', 'module'));
    }

    public function post_add(BlogRequest $request)
    {
        $module = $this->module;

        //Image upload function
        // $filename = '';
        // if($request->hasFile('image')) {
        //     $file = $request->file('image');
        //     $filename = $file->getClientOriginalName();

        //     $name = pathinfo($filename, PATHINFO_FILENAME);
        //     $ext = pathinfo($filename, PATHINFO_EXTENSION);
        //     $filename = str_slug($this->option->name).'_'.str_slug($name).'.'.$ext;
        // }

        //Image save function
        $filename = null;
        if($request->image) {
            $file = $request->image;
            // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
            // Image::make($file)->widen(800, function ($constraint) {$constraint->upsize(); })->crop(800,500)->fill('#ffffff', 0, 0)->save($file);
            Image::make($file)
                ->fit(800, 500, function ($constraint) {
                    $constraint->upsize();
                })
                ->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
        }

        //Image save function
        $this->data->fill($request->all());
        $this->data->image = $filename;
        $this->data->user_id = Auth::user()->id;

        $slug = str_slug($request->title);
        $existingSlugs = $this->data->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->data->slug = $slug.'-'.$existingSlugs : $this->data->slug = $slug;

        $this->data->status = 1;
        // $request->status == 1 ? $this->data->status = 1 : $this->data->status = 0;
        $this->data->save();

        $dataId = $this->data->id;

        //Image upload function
        // if($request->hasFile('image')) {
        //     $file = $request->file('image');
        //     $destinationPath = 'images/'.$module.'s/'.$dataId.'/';
        //     $file->move($destinationPath, $filename);
        // }

        if($request->image) {
            $file = $request->image;
            $filepath = $module.'s/'.$dataId.'/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $sessionMsg = $this->data->title;
        return redirect('admin/'.$module.'/'.$dataId.'/view')->with('success', 'Data '.$sessionMsg.' has been created');
    }

    public function get_edit($id)
    {
        $module = $this->module;

        $singleData = $this->data->find($id);
        $category = $this->category->where('status', 1)->pluck('title', 'id');
        $gallery = PhotoAlbum::where('status', 1)->pluck('title', 'id');

        return view('admin.'.$module.'.add_edit',compact('singleData', 'category', 'gallery', 'module'));
    }

    public function post_edit(BlogRequest $request, $id)
    {
        $module = $this->module;

        $this->data = $this->data->find($id);
        $oldFilename = $filename = $this->data->image;
        $this->data->fill($request->all());
        $this->data->slug = str_slug($request->slug);
        $request->status == 1 ? $this->data->status = 1 : $this->data->status = 0;

        //Image upload function
        // if($request->hasFile('image')) {
        //     $file = $request->file('image');
        //     $destinationPath = 'images/'.$module.'s/'.$id.'/';
        //     $filename = $file->getClientOriginalName();

        //     $name = pathinfo($filename, PATHINFO_FILENAME);
        //     $ext = pathinfo($filename, PATHINFO_EXTENSION);
        //     $filename = str_slug($this->option->name).'_'.str_slug($name).'.'.$ext;

        //     File::Delete($destinationPath.$oldFilename);
        //     $file->move($destinationPath, $filename);
        // }

        //Image upload function
        if($request->image) {
            $file = $request->image;
            // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
            // Image::make($file)->widen(800, function ($constraint) {$constraint->upsize(); })->crop(800,500)->fill('#ffffff', 0, 0)->save($file);
            Image::make($file)
                ->fit(800, 500, function ($constraint) {
                    $constraint->upsize();
                })
                ->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = $module.'s/'.$id.'/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete($module.'s/'.$oldFilename);
        }

        $this->data->image = $filename;
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

    public function image_delete($id)
    {
        $module = $this->module;

        $data = $this->data->find($id);
        if($data) {
            // $path = public_path().'/images/'.$module.'s/'.$id.'/'.$data->image;
            Storage::delete($module.'s/'. $id . '/' .$data->image);
            // File::Delete($path);
            $data->update(['image'=>'']);
            return redirect()->back()->with('success', 'The image has been deleted successfully.');
        }else {
            return redirect()->back()->with('error', 'The image has not been deleted.');
        }
    }

    public function soft_delete($id)
    {
        if($this->data->find($id)->delete()) {
            return redirect()->back()->with('success', 'Your data has been moved to trash');
        }else {
            return redirect()->with('error', 'Your data has not been moved to trash.');
        }
    }

    public function get_restore($id)
    {
        if($this->data->where('id', $id)->withTrashed()->first()->restore()) {
            return redirect()->back()->with('success', 'Your data has been restored.');
        }else {
            return redirect()->back()->with('error', 'Your data has not been restored.');
        }
    }

    public function force_delete($id)
    {
        $module = $this->module;

        // if($this->data->where('id', $id)->withTrashed()->first()->forceDelete()) {
        //     //Delete image
        //     $path = public_path().'/images/'.$module.'s/'.$id;
        //     File::deleteDirectory($path);
        //     return redirect()->back()->with('success', 'Your data has been permanently deleted');
        // }else {
        //     return redirect()->back()->with('error', 'Your data has not been permanently deleted.');
        // }

        $data = $this->data->where('id', $id)->withTrashed()->first();
        if($data) {
            if($data->image)
                // Storage::delete($module.'s/'.$data->id);
                Storage::deleteDirectory($module.'s/'.$id);
                $data->forceDelete();
            return redirect()->back()->with('success', 'Your data has been permanently deleted');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been permanently deleted.');
        }
    }

    public function get_trash()
    {
        $module = $this->module;

        $allData = $this->data->onlyTrashed()->paginate(15);

        return view('admin.'.$module.'.index', compact('allData', 'module'));
    }
}