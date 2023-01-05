<?php 

namespace App\Http\Controllers\Admin;

use Auth;
use App\Store;
use App\StoreCategory;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreCategoryRequest;

class StoreCategoryController extends Controller {

    public function __construct(StoreCategory $category, Store $store)
    {
        $this->module = "store";
        $this->category = $category;
        $this->store = $store;
        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $module = $this->module;
        $allData = $this->category->orderBy('id', 'DESC')->get();

        if($id) {
            $singleData = $this->category->find($id);
        }else {
            $singleData = $this->category;
        }

        return view('admin.'.$module.'.category', compact('allData', 'singleData', 'module'));
    }

    public function post_add(StoreCategoryRequest $request)
    {
        $filename = null;
        if($request->image) {
            $file = $request->image;
            // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
               Image::make($file)->widen(309, function ($constraint) {$constraint->upsize(); })->crop(309,400)->fill('#ffffff', 0, 0)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = $this->module.'-categories/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->category->fill($request->all());

        $slug = str_slug($request->title);
        $existingSlugs = $this->category->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->category->slug =$slug.$existingSlugs : $this->category->slug = $slug;

        $this->category->image = $filename;
        $this->category->status = 1;
        $this->category->user_id = Auth::id();
        $this->category->save();

        $sessionMsg = $this->category->title;
        return redirect()->back()->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function post_edit(StoreCategoryRequest $request, $id)
    {
        $this->category = $this->category->find($id);
        $oldFilename = $filename = $this->category->image;
        $this->category->fill($request->all());
        $this->category->slug = str_slug($request->slug);
        $request->status == 1 ? $this->category->status = 1 : $this->category->status = 0;

        //Image upload function
        if($request->image) {
            $file = $request->image;
            // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
            Image::make($file)->widen(309, function ($constraint) {$constraint->upsize(); })->crop(309,400)->fill('#ffffff', 0, 0)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = $this->module.'-categories/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete($this->module.'-categories/'.$oldFilename);
        }
        $this->category->image = $filename;
        $this->category->user_id = Auth::id();
        $this->category->save();

        $sessionMsg = $this->category->name;
        return redirect()->back()->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function image_delete($id)
    {
        $data = $this->category->find($id);
        if($data) {
            Storage::delete($this->module.'-categories/'.$data->image);
            $data->update(['image'=>'']);
            return redirect()->back()->with('success', 'The image has been deleted successfully.');
        }
        else {
            return redirect()->back()->with('error', 'The image has not been deleted.');
        }
    }

    public function get_delete($id)
    {
        $relatedData = Store::where('store_category_id', $id)->get();
        if(count($relatedData)>0) {
            return redirect()->back()->with('error', 'Please delete corresponding events data before delete the event category!');
        }
        else {
            $data = $this->category->find($id);
            if($data->image)
                Storage::delete($this->module.'-categories/'.$data->image);
            $data->delete();
            return redirect('admin/'.$this->module.'s-category')->with('success', 'Your data has been deleted successfully.');
        }
    }

    public function select_devision()
    {
        $cat_id = $_GET['store_cat_id'];
        $cat = $this->category->find($cat_id);
        $catSubs = $this->store->where('store_category_id',$cat_id)->where('status', 1)->get();

        // echo "<option value=''>Select store(s) of $cat->title</option>";
        foreach($catSubs as $row){
            echo "<option value=$row->store_id>$row->banner-$row->store_id</option>";
        }
    }
}