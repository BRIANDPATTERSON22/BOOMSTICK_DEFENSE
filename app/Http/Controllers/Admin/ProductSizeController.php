<?php namespace App\Http\Controllers\Admin;

use App\Product;
use App\Size;
use App\Http\Requests\Admin\ProductSizeRequest;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductSizeController extends Controller {

    public function __construct(Product $product, Size $size)
    {
        $this->module = "product";
        $this->data = $product;
        $this->size = $size;

        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $module = $this->module;
        $allData = $this->size->orderBy('id', 'DESC')->get();

        if($id) {
            $singleData = $this->size->find($id);
        }else {
            $singleData = $this->size;
        }

        return view('admin.'.$module.'.size', compact('allData', 'singleData', 'module'));
    }

    public function post_add(ProductSizeRequest $request)
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
            $filepath = 'brands/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->size->fill($request->all());

        // $slug = str_slug($request->name);
        $slug = str_slug($request->name.'-'.$request->measurement_type);
        $existingSlugs = $this->size->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->size->slug =$slug.'-'.$existingSlugs : $this->size->slug = $slug;

        $this->size->image = $filename;
        $this->size->status = 1;
        $this->size->save();

        $sessionMsg = $this->size->name;
        return redirect('admin/products-size')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function post_edit(ProductSizeRequest $request, $id)
    {
        $this->size = $this->size->find($id);
        $oldFilename = $filename = $this->size->image;
        $this->size->fill($request->all());
        $this->size->slug = str_slug($request->slug);
        $request->status == 1 ? $this->size->status = 1 : $this->size->status = 0;

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
            $filepath = 'brands/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete('brands/'.$oldFilename);
        }
        $this->size->image = $filename;
        $this->size->save();

        $sessionMsg = $this->size->name;
        return redirect('admin/products-size')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function image_delete($id)
    {
        $data = $this->size->find($id);
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
        $catData = $this->data->where('measurement_id', $id)->get();
        if(count($catData)>0) {
            return redirect('admin/products-size')->with('error', 'Please delete corresponding data before delete the size');
        }
        else {
            $data = $this->size->find($id);
            if($data->image)
                Storage::delete('brands/'.$data->image);
            $data->forceDelete();
            return redirect('admin/products-size')->with('success', 'Your data has been deleted successfully.');
        }
    }
}