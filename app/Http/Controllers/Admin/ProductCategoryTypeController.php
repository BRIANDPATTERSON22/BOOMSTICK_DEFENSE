<?php namespace App\Http\Controllers\Admin;

use App\Product;
use App\ProductCategory;
use App\ProductCategoryType;
use App\ProductCategorySub;
use App\Http\Requests\Admin\ProductSubCategoryTypeRequest;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductCategoryTypeController extends Controller {

    public function __construct(Product $product,ProductCategory $category, ProductCategoryType $productCategoryType, ProductCategorySub $categorySub)
    {
        $this->module = "product";
        $this->data = $product;
        $this->category = $category;
        $this->productCategoryType = $productCategoryType;
        $this->categorySub = $categorySub;

        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $module = $this->module;
        $allData = $this->productCategoryType->orderBy('id', 'DESC')->get();
        $categories = $this->category->pluck('name', 'id');
        $subCategories = $this->categorySub->pluck('name', 'id');

        if($id) {
            $singleData = $this->productCategoryType->find($id);
        }else {
            $singleData = $this->productCategoryType;
        }

        return view('admin.'.$module.'.product_category_type', compact('allData', 'singleData', 'module', 'categories','subCategories'));
    }

    public function post_add(ProductSubCategoryTypeRequest $request)
    {
        $filename = null;
        if($request->image)
        {
            $file = $request->image;
            // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);

            // $img    = Image::make($file);
            // $width  = $img->width();
            // $height = $img->height();
            // $dimension = 360;

            // $vertical   = (($width < $height) ? true : false);
            // $horizontal = (($width > $height) ? true : false);
            // $square     = (($width = $height) ? true : false);

            // if ($vertical) {
            //     $top = $bottom = 10;
            //     $newHeight = ($dimension) - ($bottom + $top);
            //     $img->resize(null, $newHeight, function ($constraint) {
            //         $constraint->aspectRatio();
            //     });
            // } else if ($horizontal) {
            //     $right = $left = 10;
            //     $newWidth = ($dimension) - ($right + $left);
            //     $img->resize($newWidth, null, function ($constraint) {
            //         $constraint->aspectRatio();
            //     });
            // } else if ($square) {
            //     $right = $left = 10;
            //     $newWidth = ($dimension) - ($left + $right);
            //     $img->resize($newWidth, null, function ($constraint) {
            //         $constraint->aspectRatio();
            //     });
            // }
            // $img->resizeCanvas($dimension, $dimension, 'center', false, '#ffffff')->save($file);


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
            $filepath = 'products-category-type/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->productCategoryType->fill($request->all());

        $slug = str_slug($request->name);
        $existingSlugs = $this->productCategoryType->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->productCategoryType->slug =$slug.$existingSlugs : $this->productCategoryType->slug = $slug;

        $this->productCategoryType->image = $filename;
        $this->productCategoryType->status = 1;
        $this->productCategoryType->save();

        $sessionMsg = $this->productCategoryType->name;
        return redirect('admin/products-category-type')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function post_edit(ProductSubCategoryTypeRequest $request, $id)
    {
        $this->productCategoryType = $this->productCategoryType->find($id);
        $oldFilename = $filename = $this->productCategoryType->image;
        $this->productCategoryType->fill($request->all());
        $this->productCategoryType->slug = str_slug($request->slug);
        $request->status == 1 ? $this->productCategoryType->status = 1 : $this->productCategoryType->status = 0;

        //Image upload function
        if($request->image) {
            $file = $request->image;
            // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);

            // $img    = Image::make($file);
            // $width  = $img->width();
            // $height = $img->height();
            // $dimension = 360;

            // $vertical   = (($width < $height) ? true : false);
            // $horizontal = (($width > $height) ? true : false);
            // $square     = (($width = $height) ? true : false);

            // if ($vertical) {
            //     $top = $bottom = 10;
            //     $newHeight = ($dimension) - ($bottom + $top);
            //     $img->resize(null, $newHeight, function ($constraint) {
            //         $constraint->aspectRatio();
            //     });
            // } else if ($horizontal) {
            //     $right = $left = 10;
            //     $newWidth = ($dimension) - ($right + $left);
            //     $img->resize($newWidth, null, function ($constraint) {
            //         $constraint->aspectRatio();
            //     });
            // } else if ($square) {
            //     $right = $left = 10;
            //     $newWidth = ($dimension) - ($left + $right);
            //     $img->resize($newWidth, null, function ($constraint) {
            //         $constraint->aspectRatio();
            //     });
            // }
            // $img->resizeCanvas($dimension, $dimension, 'center', false, '#ffffff')->save($file);


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
            $filepath = 'products-category-type/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete('products-category-type/'.$oldFilename);
        }
        $this->productCategoryType->image = $filename;
        $this->productCategoryType->save();

        $sessionMsg = $this->productCategoryType->name;
        return redirect('admin/products-category-type')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function image_delete($id)
    {
        $data = $this->productCategoryType->find($id);
        if($data) {
            Storage::delete('products-category-type/'.$data->image);
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
            return redirect('admin/products-category-type')->with('error', 'Please delete corresponding data before delete the brand');
        }
        else {
            $data = $this->productCategoryType->find($id);
            if($data->image)
                Storage::delete('products-category-type/'.$data->image);
            $data->delete();
            return redirect('admin/products-category-type')->with('success', 'Your data has been deleted successfully.');
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
        $subCatTypes = $this->productCategoryType->where('sub_category_id',$sub_cat_id)->where('status', 1)->orderBy('id', 'DESC')->get();

        echo "<option value=''>Select sub category type of of $subCat->name</option>";
        foreach($subCatTypes as $row){
            echo "<option value=$row->id>$row->name</option>";
        }
    }
}