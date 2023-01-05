<?php namespace App\Http\Controllers\Admin;

use App\Product;
use App\ProductCategory;
use App\OccasionProduct;
use App\ProductCategoryType;
use App\ProductCategorySub;
use App\Http\Requests\Admin\OccasionProductRequest;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductOccasionController extends Controller {

    public function __construct(Product $product,ProductCategory $category, ProductCategoryType $productCategoryType, ProductCategorySub $categorySub, OccasionProduct $occasionProduct)
    {
        $this->module = "product";
        $this->data = $product;
        $this->category = $category;
        $this->productCategoryType = $productCategoryType;
        $this->categorySub = $categorySub;
        $this->occasionProduct = $occasionProduct;

        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $module = $this->module;
        $allData = $this->occasionProduct->orderBy('id', 'DESC')->get();
        $categories = $this->category->where('status', 1)->where('id', 15)->pluck('name', 'id');
        $subCategories = $this->categorySub->where('status', 1)->where('category_id', 15)->pluck('name', 'id');
        $products = $this->data->where('status', 1)->pluck('name', 'id');

        if($id) {
            $singleData = $this->occasionProduct->find($id);
        }else {
            $singleData = $this->occasionProduct;
        }

        return view('admin.'.$module.'.occasion_products', compact('allData', 'singleData', 'module', 'categories','subCategories','products'));
    }

    public function post_add(OccasionProductRequest $request)
    {
        $filename = null;
        if($request->image)
        {
            $file = $request->image;
            $width = 360;
            $height = 200;
            $img = Image::make($file);
            if ($img->width() > $width) { 
                $img->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            if ($img->height() > $height) {
                $img->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                }); 
            }
            $img->resizeCanvas($width, $height, 'center', false, '#ffffff');
            $img->save($file);

            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'occasion-product/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->occasionProduct->fill($request->all());

        $slug = str_slug($request->name);
        $existingSlugs = $this->occasionProduct->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->occasionProduct->slug =$slug.$existingSlugs : $this->occasionProduct->slug = $slug;

        $this->occasionProduct->image = $filename;
        $this->occasionProduct->status = 1;
        $this->occasionProduct->save();

        $sessionMsg = $this->occasionProduct->name;
        return redirect('admin/occasion-product')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function post_edit(OccasionProductRequest $request, $id)
    {
        $this->occasionProduct = $this->occasionProduct->find($id);
        $oldFilename = $filename = $this->occasionProduct->image;
        $this->occasionProduct->fill($request->all());
        $this->occasionProduct->slug = str_slug($request->slug);
        $request->status == 1 ? $this->occasionProduct->status = 1 : $this->occasionProduct->status = 0;

        //Image upload function
        if($request->image) {
            $file = $request->image;

            $width = 360;
            $height = 200;
            $img = Image::make($file);
            if ($img->width() > $width) { 
                $img->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            if ($img->height() > $height) {
                $img->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                }); 
            }
            $img->resizeCanvas($width, $height, 'center', false, '#ffffff');
            $img->save($file);


            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'occasion-product/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete('occasion-product/'.$oldFilename);
        }
        $this->occasionProduct->image = $filename;
        $this->occasionProduct->save();

        $sessionMsg = $this->occasionProduct->name;
        return redirect('admin/occasion-product')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function image_delete($id)
    {
        $data = $this->occasionProduct->find($id);
        if($data) {
            Storage::delete('occasion-product/'.$data->image);
            $data->update(['image'=>'']);
            return redirect()->back()->with('success', 'The image has been deleted successfully.');
        }
        else {
            return redirect()->back()->with('error', 'The image has not been deleted.');
        }
    }

    public function get_delete($id)
    {
        $catData = $this->data->where('type_id', $id)->get();
        if(count($catData)>0) {
            return redirect('admin/occasion-product')->with('error', 'Please delete corresponding data before delete the brand');
        }
        else {
            $data = $this->occasionProduct->find($id);
            if($data->image)
                Storage::delete('occasion-product/'.$data->image);
            $data->delete();
            return redirect('admin/occasion-product')->with('success', 'Your data has been deleted successfully.');
        }
    }

    // public function select_product_category_type()
    // {
    //     $cat_id = $_GET['pro_cat_id'];
    //     $cat = $this->category->find($cat_id);
    //     $catTypes = $this->productCategoryType->where('category_id',$cat_id)->where('status', 1)->orderBy('id', 'DESC')->get();

    //     echo "<option value=''>Select category type of of $cat->name</option>";
    //     foreach($catTypes as $row){
    //         echo "<option value=$row->id>$row->name</option>";
    //     }
    // }

    public function select_product_sub_category_type()
    {
        $sub_cat_id = $_GET['pro_sub_cat_type_id'];
        $subCat = $this->categorySub->find($sub_cat_id);
        $subCatTypes = $this->occasionProduct->where('sub_category_id',$sub_cat_id)->where('status', 1)->orderBy('id', 'DESC')->get();

        echo "<option value=''>Select sub category type of of $subCat->name</option>";
        foreach($subCatTypes as $row){
            echo "<option value=$row->id>$row->name</option>";
        }
    }
}