<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\Menu;
use App\ThemeSettings;
use App\Photo;
use App\SliderImage;
use App\Http\Requests\Admin\ThemeSettingsRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;

class ThemeSettingsController extends Controller
{
    public function __construct(ThemeSettings $themeSettings)
    {
        $this->module = "theme-setting";
        $this->data = $themeSettings;
        $this->middleware('auth');
    }

    public function get_edit()
    {
        $module = $this->module;

        $singleData = $this->data->first();

        return view('admin.'.$module.'.index',compact('singleData', 'module'));
    }

    public function post_edit(ThemeSettingsRequest $request)
    {
        $module = $this->module;

        $this->data = $this->data->first();
      
        $this->data->fill($request->all());

        // dd($request->all());

        $this->data->save();

        Cache::forever('themeCache', $this->data);
        return redirect()->back()->with('success', 'Your data has been updated successfully');
    }

}