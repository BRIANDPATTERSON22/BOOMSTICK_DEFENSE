<?php namespace App\Http\Controllers\Admin;

use App\Product;
use App\ProductModel;
use App\Http\Requests\Admin\ProductModelRequest;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductModelController extends Controller {

    public function __construct(Product $product, ProductModel $model)
    {
        $this->module = "product";
        $this->data = $product;
        $this->model = $model;

        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $module = $this->module;
        $allData = $this->model->orderBy('id', 'DESC')->get();

        if($id) {
            $singleData = $this->model->find($id);
        }else {
            $singleData = $this->model;
        }

        return view('admin.'.$module.'.model', compact('allData', 'singleData', 'module'));
    }

    public function post_add(ProductModelRequest $request)
    {
        $filename = null;
        if($request->image) {
            $file = $request->image;
            Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'models/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->model->fill($request->all());

        $slug = str_slug($request->name);
        $existingSlugs = $this->model->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->model->slug =$slug.$existingSlugs : $this->model->slug = $slug;

        $this->model->image = $filename;
        $this->model->status = 1;
        $this->model->save();

        $sessionMsg = $this->model->name;
        return redirect('admin/products-model')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function post_edit(ProductModelRequest $request, $id)
    {
        $this->model = $this->model->find($id);
        $oldFilename = $filename = $this->model->image;
        $this->model->fill($request->all());
        $this->model->slug = str_slug($request->slug);
        $request->status == 1 ? $this->model->status = 1 : $this->model->status = 0;

        //Image upload function
        if($request->image) {
            $file = $request->image;
            Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'models/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete('models/'.$oldFilename);
        }
        $this->model->image = $filename;
        $this->model->save();

        $sessionMsg = $this->model->name;
        return redirect('admin/products-model')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function image_delete($id)
    {
        $data = $this->model->find($id);
        if($data) {
            Storage::delete('models/'.$data->image);
            $data->update(['image'=>'']);
            return redirect()->back()->with('success', 'The image has been deleted successfully.');
        }
        else {
            return redirect()->back()->with('error', 'The image has not been deleted.');
        }
    }

    public function get_delete($id)
    {
        $catData = $this->data->where('model_id', $id)->get();
        if(count($catData)>0) {
            return redirect('admin/products-model')->with('error', 'Please delete corresponding data before delete the model');
        }
        else {
            $data = $this->model->find($id);
            if($data->image)
                Storage::delete('models/'.$data->image);
            $data->delete();
            return redirect('admin/products-model')->with('success', 'Your data has been deleted successfully.');
        }
    }
}