<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\Menu;
use App\SectionInfo;
use App\Photo;
use App\SliderImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Admin\SectionInfoRequest;

class SectionInfoController extends Controller
{
    public function __construct(SectionInfo $sectionInfo)
    {
        $this->module = "section-info";
        $this->data = $sectionInfo;
        $this->middleware('auth');
    }

    public function get_edit()
    {
        $module = $this->module;

        $singleData = $this->data->first();

        return view('admin.'.$module.'.index',compact('singleData', 'module'));
    }

    public function post_edit(SectionInfoRequest $request)
    {
        $module = $this->module;

        $this->data = $this->data->first();
      
        $this->data->fill($request->all());

        $this->data->save();

        return redirect()->back()->with('success', 'Your data has been updated successfully');
    }
}