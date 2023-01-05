<?php namespace App\Http\Controllers\Admin;

use App\Blog;
use App\BlogCategory;
use App\Http\Requests;
use App\Http\Requests\Admin\BlogCategoryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller {

    public function __construct(Blog $blog, BlogCategory $category)
    {
        $this->module = "blog";
        $this->data = $blog;
        $this->category = $category;

        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $module = $this->module;

        $allData = $this->category->orderBy('id', 'DESC')->get();

        if($id) {
            $singleData = $this->category->find($id);
        }else {
            $singleData = new BlogCategory();
        }

        return view('admin.'.$module.'.category', compact('allData', 'singleData', 'module'));
    }

    public function post_add(BlogCategoryRequest $request)
    {
        $module = $this->module;

        $this->category->fill($request->all());
        $this->category->slug = Str::slug($request->slug);
        $this->category->save();

        $sessionMsg = $this->category->title;
        return redirect('admin/'.$module.'s/category')->with('success', 'Data '.$sessionMsg.' has been created');
    }

    public function post_edit(BlogCategoryRequest $request, $id)
    {
        $module = $this->module;

        $this->category = $this->category->find($id);
        $this->category->fill($request->all());
        $this->category->slug = Str::slug($request->slug);
        $request->status == 1 ? $this->category->status = 1 : $this->category->status = 0;
        $this->category->save();

        $sessionMsg = $this->category->title;
        return redirect('admin/'.$module.'s/category')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function get_delete($id)
    {
        $module = $this->module;

        $catData = $this->data->where('category_id', $id)->get();
        if(count($catData)>0) {
            return redirect('admin/'.$module.'s/category')->with('error', 'Please delete corresponding data before delete the category');
        }else {
            $this->category->find($id)->delete();
            return redirect('admin/'.$module.'s/category')->with('success', 'Your data has been deleted successfully.');       }
    }
}