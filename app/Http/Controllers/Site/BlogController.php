<?php

namespace App\Http\Controllers\Site;

use App\Blog;
use App\BlogCategory;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Page;

class BlogController extends Controller
{
    public function __construct(Page $page, Blog $blog, BlogCategory $category)
    {
        $this->module = "blog";
        $this->page = $page;
        $this->data = $blog;
        $this->category = $category;
        $this->middleware('guest');
    }

    public function get_all()
    {
        $module = $this->module;
        $page = $this->page->where('slug', 'like', '%'.$module.'%')->where('status', 1)->first();

        if($page) {
            $allData = $this->data->where('status', 1)->orderBy('id', 'DESC')->paginate(20);
        }
        else{
            return view('site.errors.404');
        }

        return view('site.'.$module.'.index', compact('allData', 'page'));
    }

    public function get_category($category)
    {
        $module = $this->module;
        $cat_data = $this->category->where('slug', $category)->where('status', 1)->first();

        if(isset($cat_data)){
            $cat_id = $cat_data->id;
            $allData = $this->data->where('category_id', $cat_id)->where('status', 1)->orderBy('id', 'DESC')->paginate(20);

            if(count($allData)>0) {
                return view('site.'.$module.'.index', compact('allData'));
            }
            else{
                return redirect($module.'s')->with('error', 'No Data Found for '. $category);
            }
        }
        else{
            return view('site.errors.404');
        }
    }

    public function get_single($category, $id)
    {
        $module = $this->module;

        $singleData = $this->data->find($id);
        $otherData = $this->data->where('id', '!=', $id)->where('status', 1)->orderBy('id', 'DESC')->get();

        return view('site.'.$module.'.single',compact('singleData', 'otherData'));
    }
}