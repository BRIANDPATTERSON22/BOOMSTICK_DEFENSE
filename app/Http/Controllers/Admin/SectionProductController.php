<?php namespace App\Http\Controllers\Admin;

use Auth;
use DateTime;
use App\SectionProduct;
use App\ThemeSettings;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Admin\SectionProductRequest;

class SectionProductController extends Controller
{
    public function __construct(SectionProduct $sectionProduct, ThemeSettings $themeSettings)
    {
        $this->module = "section-product";
        $this->data = $sectionProduct;
        $this->themeSettings = $themeSettings;

        $this->middleware('auth');
    }

    public function get_edit()
    {
        $module = $this->module;

        $singleData = $this->data->first();

        return view('admin.'.$module.'.index',compact('singleData', 'module'));
    }

    public function post_edit(SectionProductRequest $request)
    {
        $module = $this->module;

        $this->data = $this->data->first();
        $old_logo = $logo_name = $this->data->image;
        $this->data->fill($request->all());

        //Image upload function
        if($request->image) {
            $file_logo = $request->image;
            Image::make($file_logo)->widen(682, function ($constraint) {$constraint->upsize(); })->save($file_logo);
            $logo_name = time().'.'.$file_logo->getClientOriginalExtension();
            $logo_path = $module.'s/'.$logo_name;
            Storage::put($logo_path, file_get_contents($file_logo), 'public');
            if($old_logo)
                Storage::delete($module.'s/'.$old_logo);
        }

        $this->data->image = $logo_name;
        $request->is_active_column_1 == 1 ? $this->data->is_active_column_1 = 1 : $this->data->is_active_column_1 = 0;
        $request->is_active_column_2 == 1 ? $this->data->is_active_column_2 = 1 : $this->data->is_active_column_2 = 0;
        $request->is_active_column_3 == 1 ? $this->data->is_active_column_3 = 1 : $this->data->is_active_column_3 = 0;
        $this->data->save();

        // Save to theme Setting tabble
        $this->themeSettings = $this->themeSettings->first();
        $request->is_active_shopping == 1 ? $this->themeSettings->is_active_shopping = 1 : $this->themeSettings->is_active_shopping = 0;
        $this->themeSettings->section_display_type = $request->section_display_type;
        $this->themeSettings->carosel_category = $request->carosel_category;

        // dd($request->all());
        $this->themeSettings->save();
        Cache::forever('themeCache', $this->themeSettings);
   
        return redirect()->back()->with('success', 'Your data has been updated successfully');
    }


    public function delete_offer_image()
    {
        $module = $this->module;
        $data = SectionProduct::first();

        if($data)
        {
            Storage::delete($module.'s/'.$data->offer_image);
            $data->update(['offer_image'=>'']);
            return redirect()->back()->with('success', 'The logo has been deleted successfully.');
        }
        else
        {
            return redirect()->back()->with('error', 'The logo has not been deleted.');
        }
    }
}