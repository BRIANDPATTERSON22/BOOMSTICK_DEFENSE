<?php namespace App\Http\Controllers\Admin;

use App\RsrProduct;
use App\RsrMainCategory;
use App\Http\Requests\Admin\RsrSubCategoryRequest;
use App\Http\Controllers\Controller;
use App\RsrSubCategory;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class RsrSubCategoryController extends Controller {

    public function __construct(RsrProduct $rsrProduct, RsrMainCategory $rsrMainCategory, RsrSubCategory $rsrSubCategory)
    {
        $this->module = "rsr-product";

        $this->data = $rsrProduct;
        $this->rsrMainCategory = $rsrMainCategory;
        $this->rsrSubCategory = $rsrSubCategory;

        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $module = $this->module;
        $allData = $this->rsrSubCategory->orderBy('id', 'DESC')->paginate(20);

        if($id) {
            $singleData = $this->rsrSubCategory->find($id);
        }else {
            $singleData = $this->rsrSubCategory;
        }

        return view('admin.'.$module.'.sub_category', compact('allData', 'singleData', 'module'));
    }

    public function post_add(RsrSubCategoryRequest $request)
    {
        $filename = null;
        if($request->image) {
            $file = $request->image;
            // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
               Image::make($file)->widen(512, function ($constraint) {$constraint->upsize(); })->crop(512,512)->fill('#ffffff', 0, 0)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'rsr-sub-categories/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->rsrSubCategory->fill($request->all());

        // $slug = str_slug($request->name);
        // $existingSlugs = $this->rsrSubCategory->where('slug', 'like', '%'.$slug.'%')->count();
        // $existingSlugs > 0 ? $this->rsrSubCategory->slug =$slug.$existingSlugs : $this->rsrSubCategory->slug = $slug;

        $this->rsrSubCategory->image = $filename;
        $this->rsrSubCategory->status = 1;
        // $request->is_enabled_on_menu == 1 ? $this->rsrSubCategory->is_enabled_on_menu = 1 : $this->rsrSubCategory->is_enabled_on_menu = 0;
        $this->rsrSubCategory->save();

        $sessionMsg = $this->rsrSubCategory->name;
        return redirect('admin/rsr-sub-category')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function post_edit(RsrSubCategoryRequest $request, $id)
    {
        $this->rsrSubCategory = $this->rsrSubCategory->find($id);

        $oldFilename = $filename = $this->rsrSubCategory->image;

        $this->rsrSubCategory->fill($request->all());
        
        // $this->rsrSubCategory->slug = str_slug($request->slug);
        $request->status == 1 ? $this->rsrSubCategory->status = 1 : $this->rsrSubCategory->status = 0;
        // $request->is_enabled_on_menu == 1 ? $this->rsrSubCategory->is_enabled_on_menu = 1 : $this->rsrSubCategory->is_enabled_on_menu = 0;

        //Image upload function
        // if($request->image) {
        //     $file = $request->image;
        //     // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
        //     Image::make($file)->widen(512, function ($constraint) {$constraint->upsize(); })->crop(512,512)->fill('#ffffff', 0, 0)->save($file);
        //     $filename = time().'.'.$file->getClientOriginalExtension();
        //     $filepath = 'rsr-sub-categories/'.$filename;
        //     Storage::put($filepath, file_get_contents($file), 'public');
        //     if($oldFilename)
        //         Storage::delete('rsr-sub-categories/'.$oldFilename);
        // }
        // $this->rsrSubCategory->image = $filename;
        $this->rsrSubCategory->save();

        $sessionMsg = $this->rsrSubCategory->name;
        return redirect()->back()->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function image_delete($id)
    {
        $data = $this->rsrSubCategory->find($id);
        if($data) {
            Storage::delete('rsr-sub-categories/'.$data->image);
            $data->update(['image' => NULL]);
            return redirect()->back()->with('success', 'The image has been deleted successfully.');
        }
        else {
            return redirect()->back()->with('error', 'The image has not been deleted.');
        }
    }

    public function get_delete($id)
    {
        $catData = $this->rsrSubCategory->where('category_id', $id)->get();
        if(count($catData)>0) {
            return redirect('admin/rsr-sub-category')->with('error', 'Please delete corresponding data before delete the rsrSubCategory');
        }
        else {
            $data = $this->rsrSubCategory->find($id);
            if($data->image)
                Storage::delete('categories/'.$data->image);
            $data->delete();
            return redirect('admin/rsr-sub-category')->with('success', 'Your data has been deleted successfully.');
        }
    }

    public function select_product_category()
    {
        $cat_id = $_GET['pro_cat_id'];
        $cat = $this->rsrSubCategory->find($cat_id);
        $catSubs = $this->rsrSubCategory->where('category_id',$cat_id)->where('status', 1)->orderBy('id', 'DESC')->get();

        echo "<option value=''>Select sub categories of $cat->name</option>";
        foreach($catSubs as $row){
            echo "<option value=$row->id>$row->name</option>";
        }
    }
}