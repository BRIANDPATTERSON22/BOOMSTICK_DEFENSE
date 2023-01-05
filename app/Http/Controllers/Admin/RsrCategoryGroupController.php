<?php namespace App\Http\Controllers\Admin;

use App\CategoryGroup;
use App\CategoryGroupHasCategories;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryGroupRequest;
use App\ProductCategory;
use App\RsrMainCategory;
use App\RsrSubCategory;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class RsrCategoryGroupController extends Controller {

    public function __construct(CategoryGroup $categoryGroup, ProductCategory $productCategory, RsrMainCategory $rsrMainCategory, CategoryGroupHasCategories $categoryGroupHasCategories)
    {
        $this->module = "rsr-product";
        $this->moduleTitle = "RSR Category Groups";
        $this->modulePath = "rsr-category-groups";

        $this->data = $categoryGroup;
        $this->productCategory = $productCategory;
        $this->rsrMainCategory = $rsrMainCategory;
        $this->categoryGroupHasCategories = $categoryGroupHasCategories;

        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $module = $this->module;
        $moduleTitle = $this->moduleTitle;

        $allData = $this->data->where('is_boomstick_category', 0)->with('have_rsr_main_categories')->orderBy('id', 'DESC')->get();
        $mainCategoriesCollection = $this->rsrMainCategory->where('status', '1')->get();
        // $mainCategoriesCollection = $this->productCategory->where('status', '1')->get();
        // $mainCategoriesArray = $this->productCategory->where('status', '1')->pluck('name', 'id');

        if($id) {
            $singleData = $this->data->find($id);
            $oldCategoriesArray = $this->categoryGroupHasCategories->where('category_group_id', $id)->pluck('category_id')->toArray();
            $singleData->categories = $oldCategoriesArray;
        }else {
            $singleData = $this->data;
        }

        return view('admin.'.$module.'.category_group', compact('allData', 'singleData', 'module', 'moduleTitle', 'mainCategoriesCollection'));
    }

    public function post_add(CategoryGroupRequest $request)
    {
        $filename = null;
        if($request->image) {
            $file = $request->image;
            Image::make($file)->widen(512, function ($constraint) {$constraint->upsize(); })->crop(512,130)->fill('#ffffff', 0, 0)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = $this->modulePath.'/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->data->fill($request->all());
        $slug = str_slug($request->title);
        $existingSlugs = $this->data->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->data->slug = $slug.'-'.$existingSlugs : $this->data->slug = $slug;
        $this->data->image = $filename;
        $this->data->status = 1;
        $this->data->is_boomstick_category = 0;
        $this->data->save();
        $dataId = $this->data->id;

        //Assign Multiple Categories
        $availableCategories = null;
        if($request->categories) {
            foreach ($request->categories as $category) {
                $availableCategories[] = [
                    'category_group_id' => $dataId,
                    'category_type' => 1,
                    'category_id' =>  $category,
                    'is_boomstick_category' => 0,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ];
            }
        }
        if($availableCategories) {
            $this->categoryGroupHasCategories->insert($availableCategories);
        }

        $sessionMsg = $this->data->title;
        return redirect('admin/'.$this->modulePath)->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function post_edit(CategoryGroupRequest $request, $id)
    {
        $this->data = $this->data->find($id);

        $oldFilename = $filename = $this->data->image;

        $this->data->fill($request->all());
        
        $this->data->slug = str_slug($request->slug);
        $request->status == 1 ? $this->data->status = 1 : $this->data->status = 0;

        //Image upload function
        if($request->image) {
            $file = $request->image;
            Image::make($file)->widen(512, function ($constraint) {$constraint->upsize(); })->crop(512,130)->fill('#ffffff', 0, 0)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = $this->modulePath.'/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete($this->modulePath.'/'.$oldFilename);
        }
        $this->data->image = $filename;
        $this->data->save();

        $categoriesArray = $this->categoryGroupHasCategories->where('category_group_id', $id)->pluck('category_id')->toArray();
        $availableCategories = null;
        if($request->categories) {
            foreach ($request->categories as $category) {
                if (!in_array($category, $categoriesArray)) {
                    $availableCategories[] = [
                        'category_group_id' => $id,
                        'category_type' => 1,
                        'category_id' =>  $category,
                        'is_boomstick_category' => 0,
                        'created_at' => new DateTime,
                        'updated_at' => new DateTime,
                    ];
                } else {
                    $key = array_search($category, $categoriesArray);
                    unset($categoriesArray[$key]);
                }
            }
        }
        if($availableCategories) {
            $this->categoryGroupHasCategories->insert($availableCategories);
        }
        // Delete categories
        $this->categoryGroupHasCategories->whereIn('category_id', $categoriesArray)->where('category_group_id', $id)->forceDelete();


        $sessionMsg = $this->data->name;
        return redirect()->back()->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function image_delete($id)
    {
        $data = $this->data->find($id);
        if($data) {
            Storage::delete($this->modulePath.'/'.$data->image);
            $data->update(['image' => NULL]);
            return redirect()->back()->with('success', 'The image has been deleted successfully.');
        }
        else {
            return redirect()->back()->with('error', 'The image has not been deleted.');
        }
    }

    public function get_delete($id)
    {
        $data = $this->data->find($id);

        if(!$data){
            return redirect('admin/'.$this->modulePath)->with('error', 'Data not found!');
        }

        if($data->have_rsr_main_categories){
            foreach ($data->have_rsr_main_categories as $row) {
                $row->delete();
            }
        }

        if($data->image){
            Storage::delete($this->modulePath.'/'.$data->image);
        }

        $data->delete();

        return redirect('admin/'.$this->modulePath)->with('success', 'Your data has been deleted successfully.');
        // return redirect('admin/'.$this->modulePath)->with('error', 'Please delete corresponding data before delete the product group');
    }
}