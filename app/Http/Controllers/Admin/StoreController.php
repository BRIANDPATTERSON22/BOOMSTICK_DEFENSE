<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRequest;
use App\Store;
use App\StoreCategory;
use App\StoreProduct;
use Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class StoreController extends Controller
{
    public function __construct(Store $store, StoreCategory $storeCategory)
    {
        $this->module = "store";
        $this->data = $store;
        $this->storeCategory = $storeCategory;

        $this->option = Cache::get('optionCache');
        $this->middleware('auth');
    }

    public function get_index()
    {
        $module = $this->module;
        $deleteCount = $this->data->onlyTrashed()->count();

        $year = date('Y');
        $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'ASC')->with('user')->paginate(400);

        return view('admin.'.$module.'.index', compact('allData', 'module', 'deleteCount', 'year'));
    }

    public function get_archive($year)
    {
        $module = $this->module;
        $deleteCount = $this->data->onlyTrashed()->count();

        $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->with('user')->get();

        return view('admin.'.$module.'.index', compact('allData', 'module', 'deleteCount', 'year'));
    }


    public function get_trash()
    {
        $module = $this->module;
        $allData = $this->data->onlyTrashed()->paginate(10);

        return view('admin.'.$module.'.index', compact('allData', 'module'));
    }

    public function get_add()
    {
        $module = $this->module;
        $singleData = $this->data;
        // $arrCourseCategory = CourseCategory::where('status', 1)->pluck('title', 'id')->toArray();
        $storeCategoriesData = $this->storeCategory->where('status', 1)->pluck('title', 'id');

        return view('admin.'.$module.'.add_edit', compact('singleData', 'module', 'storeCategoriesData'));
    }

    public function post_add(StoreRequest $request)
    {
        $module = $this->module;

        //Image save function
        $filename = null;
        if($request->image) {
            $file = $request->image;
            // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
            Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->crop(1024,768)->fill('#ffffff', 0, 0)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = $module.'s/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->data->fill($request->all());
        $this->data->image = $filename;
        $this->data->user_id = Auth::id();

        $slug = str_slug($request->title);
        $existingSlugs = $this->data->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->data->slug =$slug.$existingSlugs : $this->data->slug = $slug;

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

        // $arrCourseCategory = CourseCategory::where('status', 1)->pluck('title', 'id')->toArray();
        $storeCategoriesData = $this->storeCategory->where('status', 1)->pluck('title', 'id');

        return view('admin.'.$module.'.add_edit',compact('singleData', 'module', 'storeCategoriesData'));
    }

    public function post_edit(StoreRequest $request, $id)
    {
        $module = $this->module;

        $this->data = $this->data->find($id);
        $oldFilename = $filename = $this->data->image;
        $this->data->fill($request->all());
        $this->data->slug = str_slug($request->slug);
        $request->status == 1 ? $this->data->status = 1 : $this->data->status = 0;

        //Image upload function
        if($request->image) {
            $file = $request->image;
            // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
            Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->crop(1024,768)->fill('#ffffff', 0, 0)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = $module.'s/'.$filename;
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
        $singleDataColumns = $singleData->getTableColumns();

        // $a = StoreProduct::where('store_id', $singleData->store_id)->with('product')->get()->dd();

        return view('admin.'.$module.'.view',compact('singleData', 'module', 'singleDataColumns'));
    }

    public function image_delete($id)
    {
        $module = $this->module;

        $data = $this->data->find($id);
        if($data) {
            Storage::delete($module.'s/'.$data->image);
            $data->update(['image'=>'']);
            return redirect()->back()->with('success', 'The image has been deleted successfully.');
        }
        else {
            return redirect()->back()->with('error', 'The image has not been deleted.');
        }
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
        $module = $this->module;
        $data = $this->data->where('id', $id)->withTrashed()->first();
        if($data) {
            if($data->image)
                Storage::delete($module.'s/'.$data->image);
            $data->forceDelete();
            return redirect()->back()->with('success', 'Your data has been permanently deleted');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been permanently deleted.');
        }
    }
}