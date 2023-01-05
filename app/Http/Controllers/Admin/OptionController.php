<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OptionRequest;
use App\Menu;
use App\Option;
use App\Photo;
use App\SliderImage;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class OptionController extends Controller
{
    public function __construct(Option $option, Photo $photo, Menu $menu, SliderImage $slider)
    {
        $this->module = "option";
        $this->data = $option;
        $this->photo = $photo;
        $this->menu = $menu;
        $this->slider = $slider;
        $this->middleware('auth');
    }

    public function get_edit()
    {
        $module = $this->module;

        $singleData = $this->data->first();

        return view('admin.'.$module.'.index',compact('singleData', 'module'));
    }

    public function post_edit(OptionRequest $request)
    {
        $module = $this->module;

        $this->data = $this->data->first();
        $old_favicon = $favicon_name = $this->data->favicon;
        $old_logo = $this->data->logo;
        $old_bg_breadcrumb = $bg_breadcrumb_name = $this->data->bg_breadcrumb;
        $this->data->fill($request->all());

        //Favicon upload function
        if($request->favicon) {
            $file_favicon = $request->favicon;
            // Image::make($file_favicon)->widen(100, function ($constraint) {$constraint->upsize(); })->save($file_favicon);
            Image::make($file_favicon)->widen(75, function ($constraint) {$constraint->upsize(); })->crop(75,75)->fill('#ffffff', 0, 0)->save($file_favicon);
            $favicon_name = str_slug($this->data->name).'-favicon.'.$file_favicon->getClientOriginalExtension();
            $favicon_path = $module.'s/'.$favicon_name;
            Storage::put($favicon_path, file_get_contents($file_favicon), 'public');
            if($old_favicon)
                Storage::delete($module.'s/'.$old_favicon);
        }
        $this->data->favicon = $favicon_name;

        //Logo upload function
        if($request->logo) {
            if($old_logo)
                Storage::delete($module.'s/'.$old_logo);
            $file_logo = $request->logo;
            Image::make($file_logo)->widen(270, function ($constraint) {$constraint->upsize(); })->save($file_logo);
            // $logo_name = time().$file_logo->getClientOriginalName();
            $logo_name = str_slug($this->data->name).'-logo.'.$file_logo->getClientOriginalExtension();
            $logo_path = $module.'s/'.$logo_name;
            Storage::put($logo_path, file_get_contents($file_logo), 'public');
            $this->data->logo = $logo_name;
        }

        //Breadcrumb upload function
        if($request->bg_breadcrumb) {
            $file_bg_breadcrumb = $request->bg_breadcrumb;
            // Image::make($file_bg_breadcrumb)->widen(173, function ($constraint) {$constraint->upsize(); })->save($file_bg_breadcrumb);
            // Image::make($file_bg_breadcrumb)->widen(1920, function ($constraint) {$constraint->upsize(); })->crop(1920,600)->fill('#ebebeb', 0, 0)->save($file_bg_breadcrumb);
            // $bg_breadcrumb_name = time().$file_bg_breadcrumb->getClientOriginalName();
            Image::make($file_bg_breadcrumb)
                ->fit(1400, 600, function ($constraint) {
                    $constraint->upsize();
                })
                ->save($file_bg_breadcrumb);
            $bg_breadcrumb_name = str_slug($this->data->name).'-bg_breadcrumb'.time().'.'.$file_bg_breadcrumb->getClientOriginalExtension();
            $logo_path = $module.'s/'.$bg_breadcrumb_name;
            Storage::put($logo_path, file_get_contents($file_bg_breadcrumb), 'public');
            if($old_bg_breadcrumb)
                Storage::delete($module.'s/'.$old_bg_breadcrumb);
        }
        $this->data->bg_breadcrumb = $bg_breadcrumb_name;

        $this->data->custom_css_style = $request->content_value;

        // {
        //     "section_one_title": "One",
        //     "section_one_title_small": "One",
        // }

        // $this->data->theme_settings["section_one_title"]= ["About Us"];
        $themeSettings = $request->only('section_one_title','section_two_title');
        $this->data->theme_settings = $themeSettings;
        $this->data->save();

        Cache::forever('optionCache', $this->data);
        return redirect()->back()->with('success', 'Your data has been updated successfully');
    }

    public function delete_logo()
    {
        $module = $this->module;
        $data = Option::first();

        if($data)
        {
            Storage::delete($module.'s/'.$data->logo);
            $data->update(['logo'=> NULL]);
            return redirect()->back()->with('success', 'The logo has been deleted successfully.');
        }
        else
        {
            return redirect()->back()->with('error', 'The logo has not been deleted.');
        }
    }

    public function delete_favicon()
    {
        $module = $this->module;
        $data = Option::first();

        if($data)
        {
            Storage::delete($module.'s/'.$data->favicon);
            $data->update(['favicon'=> NULL]);
            return redirect()->back()->with('success', 'The favicon has been deleted successfully.');
        }
        else
        {
            return redirect()->back()->with('error', 'The favicon has not been deleted.');
        }
    }

    public function delete_bg_breadcrumb()
    {
        $module = $this->module;
        $data = Option::first();

        if($data)
        {
            Storage::delete($module.'s/'.$data->bg_breadcrumb);
            $data->update(['bg_breadcrumb'=> NULL]);
            return redirect()->back()->with('success', 'The bg_breadcrumb has been deleted successfully.');
        }
        else
        {
            return redirect()->back()->with('error', 'The bg_breadcrumb has not been deleted.');
        }
    }

    //Common functions
    public function get_order()
    {
        $table_name = $_GET["table_name"];

        $array = json_decode($_GET["order_id"]);

        if($table_name=='photos'){
            $o_i =0;
            for($n=1; $n<(count($array)); $n++ ){
                $o_i++;
                $this->photo = $this->photo->find($array[$n]);
                $this->photo->order=$o_i;
                $this->photo->save();
            }
        }
        elseif($table_name=='menus'){
            $o_i =0;
            for($n=1; $n<(count($array)); $n++ ){
                $o_i++;
                $this->menu = $this->menu->find($array[$n]);
                $this->menu->order=$o_i;
                $this->menu->save();
            }
        }elseif($table_name=='slider_images'){
            $o_i =0;
            for($n=1; $n<(count($array)); $n++ ){
                $o_i++;
                $this->slider = $this->slider->find($array[$n]);
                $this->slider->order=$o_i;
                $this->slider->save();
            }
        }

    }

    public function get_setting()
    {
        $module = $this->module;
        $singleData = $this->data->first();
        return view('admin.'.$module.'.product_setting',compact('singleData', 'module'));
    }

    public function post_setting(Request $request)
    {
        $module = $this->module;

        $this->data = $this->data->first();
        $this->data->fill($request->all());
        $this->data->save();

        Cache::forever('optionCache', $this->data);
        return redirect()->back()->with('success', 'Your data has been updated successfully');
    }
}