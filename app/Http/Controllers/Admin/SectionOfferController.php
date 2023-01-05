<?php namespace App\Http\Controllers\Admin;

use Auth;
use DateTime;
use App\Menu;
use App\SectionOffer;
use App\Photo;
use App\SliderImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Admin\SectionOfferRequest;

class SectionOfferController extends Controller
{
    public function __construct(SectionOffer $sectionOffer)
    {
        $this->module = "section-offer";
        $this->data = $sectionOffer;
        $this->middleware('auth');
    }

    public function get_edit()
    {
        $module = $this->module;

        $singleData = $this->data->first();

        return view('admin.'.$module.'.index',compact('singleData', 'module'));
    }

    public function post_edit(SectionOfferRequest $request)
    {
        $module = $this->module;

        $this->data = $this->data->first();
        $old_logo = $logo_name = $this->data->offer_image;
        $this->data->fill($request->all());

        //Image upload function
        if($request->offer_image) {
            $file_logo = $request->offer_image;
            Image::make($file_logo)->widen(682, function ($constraint) {$constraint->upsize(); })->save($file_logo);
            $logo_name = time().'.'.$file_logo->getClientOriginalExtension();
            $logo_path = $module.'s/'.$logo_name;
            Storage::put($logo_path, file_get_contents($file_logo), 'public');
            if($old_logo)
                Storage::delete($module.'s/'.$old_logo);
        }
        
        $this->data->offer_image = $logo_name;

        $this->data->save();

        return redirect()->back()->with('success', 'Your data has been updated successfully');
    }


    public function delete_offer_image()
    {
        $module = $this->module;
        $data = SectionOffer::first();

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