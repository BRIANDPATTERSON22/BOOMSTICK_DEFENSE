<?php namespace App\Http\Controllers\Admin;

use App\Product;
use App\ProductCategory;
use App\Http\Requests\Admin\ProductCategoryRequest;
use App\Http\Controllers\Controller;
use App\ProductCategorySub;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller {

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
        $allData = $this->category->orderBy('id', 'DESC')->get();

        if($id) {
            $singleData = $this->category->find($id);
        }else {
            $singleData = $this->category;
        }

        return view('admin.'.$module.'.category', compact('allData', 'singleData', 'module'));
    }

    public function post_add(ProductCategoryRequest $request)
    {
        $filename = null;
        if($request->image) {
            $file = $request->image;
            // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
               Image::make($file)->widen(512, function ($constraint) {$constraint->upsize(); })->crop(512,512)->fill('#ffffff', 0, 0)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'categories/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->category->fill($request->all());

        $slug = str_slug($request->name);
        $existingSlugs = $this->category->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->category->slug =$slug.$existingSlugs : $this->category->slug = $slug;

        $this->category->image = $filename;
        $this->category->status = 1;
        $this->category->save();

        $sessionMsg = $this->category->name;
        return redirect('admin/products-category')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function post_edit(ProductCategoryRequest $request, $id)
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
            Image::make($file)->widen(512, function ($constraint) {$constraint->upsize(); })->crop(512,512)->fill('#ffffff', 0, 0)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'categories/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete('categories/'.$oldFilename);
        }
        $this->category->image = $filename;
        $this->category->save();

        $sessionMsg = $this->category->name;
        return redirect('admin/products-category')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function image_delete($id)
    {
        $data = $this->category->find($id);
        if($data) {
            Storage::delete('categories/'.$data->image);
            $data->update(['image'=> NULL]);
            return redirect()->back()->with('success', 'The image has been deleted successfully.');
        }
        else {
            return redirect()->back()->with('error', 'The image has not been deleted.');
        }
    }

    public function get_delete($id)
    {
        $catData = $this->categorySub->where('category_id', $id)->get();
        if(count($catData)>0) {
            return redirect('admin/products-category')->with('error', 'Please delete corresponding data before delete the category');
        }
        else {
            $data = $this->category->find($id);
            if($data->image)
                Storage::delete('categories/'.$data->image);
            $data->delete();
            return redirect('admin/products-category')->with('success', 'Your data has been deleted successfully.');
        }
    }

    public function select_product_category()
    {
        $cat_id = $_GET['pro_cat_id'];
        $cat = $this->category->find($cat_id);
        $catSubs = $this->categorySub->where('category_id',$cat_id)->where('status', 1)->orderBy('id', 'DESC')->get();

        echo "<option value=''>Select sub categories of $cat->name</option>";
        foreach($catSubs as $row){
            echo "<option value=$row->id>$row->name</option>";
        }
    }
}