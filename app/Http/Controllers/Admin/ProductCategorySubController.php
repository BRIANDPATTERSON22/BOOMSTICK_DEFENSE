<?php namespace App\Http\Controllers\Admin;

use App\Product;
use App\ProductCategory;
use App\ProductCategorySub;
use App\Http\Requests\Admin\ProductCategorySubRequest;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductCategorySubController extends Controller {

    public function __construct(Product $product, ProductCategory $category, ProductCategorySub $categorySub)
    {
        $this->module = "product";
        $this->data = $product;
        $this->category = $category;
        $this->categorySub = $categorySub;

        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $module = $this->module;

        $allData = $this->categorySub->orderBy('category_id', 'ASC')->orderBy('id', 'DESC')->get();
        $categories = $this->category->pluck('name', 'id');

        if($id) {
            $singleData = $this->categorySub->find($id);
        }else {
            $singleData = $this->categorySub;
        }

        return view('admin.'.$module.'.category_sub', compact('allData','singleData', 'module', 'categories'));
    }

    public function post_add(ProductCategorySubRequest $request)
    {
        $filename = null;
        if($request->image) {
            $file = $request->image;
            // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
            Image::make($file)->widen(309, function ($constraint) {$constraint->upsize(); })->crop(309,400)->fill('#ffffff', 0, 0)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'category-sub/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->categorySub->fill($request->all());

        $slug = str_slug($request->name);
        $existingSlugs = $this->categorySub->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->categorySub->slug =$slug.$existingSlugs : $this->categorySub->slug = $slug;

        $this->categorySub->image = $filename;
        $this->categorySub->status = 1;
        $this->categorySub->save();

        $sessionMsg = $this->categorySub->name;
        return redirect('admin/products-category-sub')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function post_edit(ProductCategorySubRequest $request, $id)
    {
        $this->categorySub = $this->categorySub->find($id);
        $oldFilename = $filename = $this->categorySub->image;
        $this->categorySub->fill($request->all());
        $this->categorySub->slug = str_slug($request->slug);
        $request->status == 1 ? $this->categorySub->status = 1 : $this->categorySub->status = 0;

        //Image upload function
        if($request->image) {
            $file = $request->image;
            // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
            Image::make($file)->widen(309, function ($constraint) {$constraint->upsize(); })->crop(309,400)->fill('#ffffff', 0, 0)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'category-sub/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete('category-sub/'.$oldFilename);
        }
        $this->categorySub->image = $filename;
        $this->categorySub->save();

        $sessionMsg = $this->categorySub->name;
        // return redirect('admin/products-category-sub')->with('success', 'Data '.$sessionMsg.' has been updated');
        return redirect()->back()->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function image_delete($id)
    {
        $data = $this->categorySub->find($id);
        if($data) {
            Storage::delete('category-sub/'.$data->image);
            $data->update(['image'=>'']);
            return redirect()->back()->with('success', 'The image has been deleted successfully.');
        }
        else {
            return redirect()->back()->with('error', 'The image has not been deleted.');
        }
    }

    public function get_delete($id)
    {
        $catData = $this->data->where('sub_category_id', $id)->get();

        if(count($catData)>0) {
            return redirect('admin/products-category-sub')->with('error', 'Please delete corresponding data before delete the category');
        }else {
            $data = $this->categorySub->find($id);
            if($data->image)
                Storage::delete('category-sub/'.$data->image);
            $data->delete();
            return redirect('admin/products-category-sub')->with('success', 'Your data has been deleted successfully.');
        }
    }
}