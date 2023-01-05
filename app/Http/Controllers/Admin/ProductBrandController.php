<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductBrandRequest;
use App\Product;
use App\ProductBrand;
use App\SalesPerson;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductBrandController extends Controller {

    public function __construct(Product $product, ProductBrand $brand)
    {
        $this->module = "product";
        $this->data = $product;
        $this->brand = $brand;

        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $module = $this->module;
        $allData = $this->brand->orderBy('id', 'DESC')->get();
        $salesPersonsData = SalesPerson::where('status', 1)->pluck('title', 'id');

        if($id) {
            $singleData = $this->brand->find($id);
        }else {
            $singleData = $this->brand;
        }

        return view('admin.'.$module.'.brand', compact('allData', 'singleData', 'module', 'salesPersonsData'));
    }

    public function post_add(ProductBrandRequest $request)
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


            // $width = 360;
            // $height = 200;
            // $img = Image::make($file);
            // if ($img->width() > $width) { 
            //     $img->resize($width, null, function ($constraint) {
            //         $constraint->aspectRatio();
            //     });
            // }
            // if ($img->height() > $height) {
            //     $img->resize(null, $height, function ($constraint) {
            //         $constraint->aspectRatio();
            //     }); 
            // }
            // $img->resizeCanvas($width, $height, 'center', false, '#ffffff');
            // $img->save($file);

            // Image::make($file)->widen(600, function ($constraint) {$constraint->upsize(); })->crop(600,400)->fill('#ffffff', 0, 0)->save($file);

            Image::make($file)
                ->fit(600, 400, function ($constraint) {
                    $constraint->upsize();
                })
                ->save($file);


            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'brands/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->brand->fill($request->all());

        $slug = str_slug($request->name);
        $existingSlugs = $this->brand->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->brand->slug =$slug.$existingSlugs : $this->brand->slug = $slug;

        $this->brand->image = $filename;
        $this->brand->status = 1;
        $this->brand->save();

        $sessionMsg = $this->brand->name;
        return redirect('admin/products-brand')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function post_edit(ProductBrandRequest $request, $id)
    {
        $this->brand = $this->brand->find($id);
        $oldFilename = $filename = $this->brand->image;
        $this->brand->fill($request->all());
        $this->brand->slug = str_slug($request->slug);
        $request->status == 1 ? $this->brand->status = 1 : $this->brand->status = 0;

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


            // $width = 360;
            // $height = 200;
            // $img = Image::make($file);
            // if ($img->width() > $width) { 
            //     $img->resize($width, null, function ($constraint) {
            //         $constraint->aspectRatio();
            //     });
            // }
            // if ($img->height() > $height) {
            //     $img->resize(null, $height, function ($constraint) {
            //         $constraint->aspectRatio();
            //     }); 
            // }
            // $img->resizeCanvas($width, $height, 'center', false, '#ffffff');
            // $img->save($file);

            // Image::make($file)->widen(600, function ($constraint) {$constraint->upsize(); })->crop(600,400)->fill('#ffffff', 0, 0)->save($file);
            Image::make($file)
                ->fit(600, 400, function ($constraint) {
                    $constraint->upsize();
                })
                ->save($file);

            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'brands/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete('brands/'.$oldFilename);
        }
        $this->brand->image = $filename;
        $this->brand->save();

        $sessionMsg = $this->brand->name;
        return redirect('admin/products-brand')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function image_delete($id)
    {
        $data = $this->brand->find($id);
        if($data) {
            Storage::delete('brands/'.$data->image);
            $data->update(['image'=>'']);
            return redirect()->back()->with('success', 'The image has been deleted successfully.');
        }
        else {
            return redirect()->back()->with('error', 'The image has not been deleted.');
        }
    }

    public function get_delete($id)
    {
        $catData = $this->data->where('brand_id', $id)->get();
        if(count($catData)>0) {
            return redirect('admin/products-brand')->with('error', 'Please delete corresponding data before delete the brand');
        }
        else {
            $data = $this->brand->find($id);
            if($data->image)
                Storage::delete('brands/'.$data->image);
            $data->delete();
            return redirect('admin/products-brand')->with('success', 'Your data has been deleted successfully.');
        }
    }
}