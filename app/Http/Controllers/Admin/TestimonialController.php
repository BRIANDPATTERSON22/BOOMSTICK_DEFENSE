<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\Photo;
use App\PhotoAlbum;
use App\Testimonial;
use App\Http\Requests\Admin\TestimonialRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function __construct(Testimonial $testimonial)
    {
        $this->data = $testimonial;

        $this->loginUser = Auth::user();
        $this->option = Cache::get('optionCache');
        $this->middleware('auth');
    }

    public function get_index()
    {
        $year = date('Y');
        $deleteCount = $this->data->onlyTrashed()->count();
        $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->get();

        return view('admin.testimonial.index', compact('allData', 'deleteCount', 'year'));
    }

    public function get_archive($year)
    {
        $deleteCount = $this->data->onlyTrashed()->count();
        $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->get();

        return view('admin.testimonial.index', compact('allData','deleteCount', 'year'));
    }

    public function get_trash()
    {
        $allData = $this->data->onlyTrashed()->get();
        return view('admin.testimonial.index', compact('allData'));
    }

    public function get_add()
    {
        $singleData = new Testimonial();
        $gallery = PhotoAlbum::where('status', 1)->pluck('title', 'id');

        return view('admin.testimonial.add_edit', compact('singleData', 'gallery'));
    }

    public function post_add(TestimonialRequest $request)
    {
        // $filename = '';
        // if(Input::hasFile('image')) {
        //     $file = Input::file('image');
        //     $filename = $file->getClientOriginalName();

        //     $name = pathinfo($filename, PATHINFO_FILENAME);
        //     $ext = pathinfo($filename, PATHINFO_EXTENSION);
        //     $filename = str_slug($this->option->name).'_'.str_slug($name).'.'.$ext;
        // }

        //Image save function
        $filename = null;
        if($request->image) {
            $file = $request->image;
            Image::make($file)->widen(300, function ($constraint) {$constraint->upsize(); })->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'testimonials/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->data->fill($request->all());
        $this->data->image = $filename;
        $this->data->user_id = $this->loginUser->id;

        $slug = str_slug($this->data->first_name);
        if($slug) {
            $existingSlugs = $this->data->where('slug', $slug)->count();
            $existingSlugs > 0 ? $this->data->slug = $slug . $existingSlugs : $this->data->slug = $slug;
        }
        else{
            $this->data->slug = 'testimonial-'.time();
        }

        $this->data->status = 1;
        $this->data->save();
        $dataId = $this->data->id;

        //Image upload function
        // if(Input::hasFile('image')) {
        //     $file = Input::file('image');
        //     Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
        //     $destinationPath = 'images/testimonials/'.$dataId.'/';
        //     $file->move($destinationPath, $filename);
        // }



        $sessionMsg = $this->data->title;
        return redirect('admin/testimonial/'.$dataId.'/view')->with('success', 'Testimonial '.$sessionMsg.' has been created');
    }

    public function get_edit($id)
    {
        $singleData = $this->data->find($id);
        $gallery = PhotoAlbum::where('status', 1)->pluck('title', 'id');

        return view('admin.testimonial.add_edit',compact('singleData', 'gallery'));
    }

    public function post_edit(TestimonialRequest $request, $id)
    {
        $this->data = $this->data->find($id);
        $oldFilename = $filename = $this->data->image;
        $this->data->fill($request->all());
        $this->data->slug = str_slug($request->slug);

        //Image upload function
        // if(Input::hasFile('image')) {
        //     $file = Input::file('image');
        //     Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
        //     $destinationPath = 'images/testimonials/'.$id.'/';
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
            Image::make($file)->widen(300, function ($constraint) {$constraint->upsize(); })->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'testimonials/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete('testimonials/'.$oldFilename);
        }

        $this->data->image = $filename;
        $request->status == 1 ? $this->data->status = 1 : $this->data->status = 0;
        $this->data->save();

        $sessionMsg = $this->data->title;
        return redirect('admin/testimonial/'.$id.'/view')->with('success', 'Testimonial '.$sessionMsg.' has been updated');
    }

    public function image_delete($id)
    {
        $data = $this->data->find($id);
        if($data) {
            // $path = public_path().'/images/testimonials/'.$id.'/'.$data->image;
            // File::Delete($path);
            Storage::delete('testimonials/'.$data->image);
            $data->update(['image'=>'']);
            return redirect()->back()->with('success', 'Your data has been deleted successfully.');
        }else {
            return redirect()->back()->with('error', 'Your data has not been deleted.');
        }
    }

    public function get_view($id)
    {
        $singleData = $this->data->find($id);
        $photos = Photo::where('album_id', $singleData->album_id)->get();

        return view('admin.testimonial.view',compact('singleData', 'photos'));
    }

    public function soft_delete($id)
    {
        if($this->data->find($id)->delete()) {
            return redirect()->back()->with('success', 'Your data has been moved to trash');
        }else {
            return redirect()->back()->with('error', 'Your data has not been moved to trash.');
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
        $data = $this->data->where('id', $id)->withTrashed()->first();
        if($data) {
            // $path = public_path().'/images/testimonials/'.$id;
            // File::deleteDirectory($path);
            Storage::delete('testimonials/'.$data->image);
            $data->forceDelete();
            return redirect()->back()->with('success', 'Your data has been permanently deleted');
        }else {
            return redirect()->back()->with('error', 'Your data has not been permanently deleted.');
        }
    }
}