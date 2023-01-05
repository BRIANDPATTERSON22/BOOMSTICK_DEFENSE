<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RsrMainCategoryRequest;
use App\RsrMainCategory;
use App\RsrMainCategoryAttributes;
use App\RsrProduct;
use App\RsrSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Schema;

class RsrMainCategoryController extends Controller {

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
        // $allData = $this->rsrMainCategory->orderBy('id', 'DESC')->get();
        $allData = $this->rsrMainCategory->orderBy('department_name', 'ASC')->get();

        if($id) {
            $singleData = $this->rsrMainCategory->find($id);
        }else {
            $singleData = $this->rsrMainCategory;
        }

        return view('admin.'.$module.'.main_category', compact('allData', 'singleData', 'module'));
    }

    public function post_add(RsrMainCategoryRequest $request)
    {
        $filename = null;
        if($request->image) {
            $file = $request->image;
            // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
               Image::make($file)->widen(512, function ($constraint) {$constraint->upsize(); })->crop(512,512)->fill('#ffffff', 0, 0)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'rsr-mian-categories/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->rsrMainCategory->fill($request->all());

        $slug = str_slug($request->name);
        $existingSlugs = $this->rsrMainCategory->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->rsrMainCategory->slug =$slug.$existingSlugs : $this->rsrMainCategory->slug = $slug;

        $this->rsrMainCategory->image = $filename;
        $this->rsrMainCategory->status = 1;
        // $request->is_enabled_on_menu == 1 ? $this->rsrMainCategory->is_enabled_on_menu = 1 : $this->rsrMainCategory->is_enabled_on_menu = 0;
        $this->rsrMainCategory->save();

        $sessionMsg = $this->rsrMainCategory->name;
        return redirect('admin/rsr-main-categories')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function post_edit(RsrMainCategoryRequest $request, $id)
    {
        $this->rsrMainCategory = $this->rsrMainCategory->find($id);

        $oldFilename = $filename = $this->rsrMainCategory->image;

        $this->rsrMainCategory->fill($request->all());
        
        $this->rsrMainCategory->slug = str_slug($request->slug);
        $request->status == 1 ? $this->rsrMainCategory->status = 1 : $this->rsrMainCategory->status = 0;
        // $request->is_enabled_on_menu == 1 ? $this->rsrMainCategory->is_enabled_on_menu = 1 : $this->rsrMainCategory->is_enabled_on_menu = 0;

        //Image upload function
        if($request->image) {
            $file = $request->image;
            // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
            Image::make($file)->widen(512, function ($constraint) {$constraint->upsize(); })->crop(512,512)->fill('#ffffff', 0, 0)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'rsr-mian-categories/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete('rsr-mian-categories/'.$oldFilename);
        }
        $this->rsrMainCategory->image = $filename;
        $this->rsrMainCategory->save();

        $sessionMsg = $this->rsrMainCategory->name;
        return redirect()->back()->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function image_delete($id)
    {
        $data = $this->rsrMainCategory->find($id);
        if($data) {
            Storage::delete('rsr-mian-categories/'.$data->image);
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
            return redirect('admin/rsr-main-category')->with('error', 'Please delete corresponding data before delete the rsrMainCategory');
        }
        else {
            $data = $this->rsrMainCategory->find($id);
            if($data->image)
                Storage::delete('categories/'.$data->image);
            $data->delete();
            return redirect('admin/rsr-main-category')->with('success', 'Your data has been deleted successfully.');
        }
    }

    public function select_product_category()
    {
        $cat_id = $_GET['pro_cat_id'];
        $cat = $this->rsrMainCategory->find($cat_id);
        $catSubs = $this->rsrSubCategory->where('category_id',$cat_id)->where('status', 1)->orderBy('id', 'DESC')->get();

        echo "<option value=''>Select sub categories of $cat->name</option>";
        foreach($catSubs as $row){
            echo "<option value=$row->id>$row->name</option>";
        }
    }

    public function get_rsr_retail_markup()
    {
        $module = $this->module;
        // $allData = $this->rsrMainCategory->orderBy('id', 'DESC')->get();
        $allData = $this->rsrMainCategory->orderBy('department_name', 'ASC')->get();

        return view('admin.'.$module.'.retail_markup', compact('allData', 'module'));
    }

    public function post_rsr_retail_markup(Request $request)
    {
        // dd($request->all());
        $module = $this->module;

        $rsrMainCategoryId = $request->rsr_main_category_id;
        $retailPricePercentageValue = $request->retail_price_percentage;

        $singleMainCategoryData = $this->rsrMainCategory->where('id', $rsrMainCategoryId)->first();
        $singleMainCategoryData->retail_price_percentage = $retailPricePercentageValue ;
        $result = $singleMainCategoryData->save();

        return response()->json([
            'status' => $result ,
        ]);

         // return redirect()->back()->with('success', 'Data has been updated');
    }

    public function get_rsr_main_category_filter_attributes()
    {
        $module = $this->module;

        $allData = RsrMainCategoryAttributes::where('status', 1)
            // ->whereHas('have_rsr_main_category', function($query) {
            //     $query->orderBy('category_name', 'DSC');
            // })
            ->GroupBy('category_id')
            // ->orderBy('category_id', 'DSC')
            ->paginate(7);

        // ---
        $allColumns = Schema::getColumnListing('rsr_main_category_attributes');
        $removableColumns = ['id', 'category_id', 'department_id', 'created_at', 'updated_at', 'status'];
        $columns = array_diff($allColumns, $removableColumns);

        return view('admin.'.$module.'.main_category_attributes_display', compact( 'module', 'allData', 'columns'));
    }

    public function post_rsr_main_category_filter_attributes(Request $request)
    {
        // dd($request->all());
        $module = $this->module;

        $attributeValue = $request->attribute_value;
        $rsrRowId = $request->rsr_main_category_id;
        $columnName = $request->column_name;
        $rsrMainCategoryId = $request->rsr_main_category_id;
        $rsrDepartmentId = $request->rsr_department_id;

        $singleData = RsrMainCategoryAttributes::where('department_id', $rsrDepartmentId)->first();
        $singleData->$columnName = $attributeValue ;
        $result = $singleData->save();

        return response()->json([
            'status' => $result ,
        ]);

         // return redirect()->back()->with('success', 'Data has been updated');
    }
}