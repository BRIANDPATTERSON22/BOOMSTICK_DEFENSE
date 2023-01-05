<?php namespace App\Http\Controllers\Admin;

use Auth;
use DateTime;
use App\Slider;
use App\SliderImage;
use App\Http\Requests\Admin\SliderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function __construct(Slider $slider, SliderImage $photo)
    {
        $this->module = "slider";
        $this->data = $slider;
        $this->photo = $photo;

        $this->option = Cache::get('optionCache');
        $this->middleware('auth');
    }

    public function get_edit()
    {
        $module = $this->module;

        $singleData = $this->data->first();
        $photos = $this->photo->orderBy('order', 'ASC')->get();

        return view('admin.'.$module.'.index',compact('singleData', 'photos', 'module'));
    }

    public function post_edit(SliderRequest $request)
    {
        $module = $this->module;

        $this->data = $this->data->first();
        $old_image = $image_name = $this->data->image;
        $old_video = $video_name = $this->data->video;
        $this->data->fill($request->all());

        //Image upload function
        if($request->image)
        {
            $image = $request->image;
            // Image::make($image)->widen(1400)->save($image);
            $image_name = 'slider_'.time().'.'.$image->getClientOriginalExtension();
            $image_path = $module.'s/'.$image_name;
            Storage::put($image_path, file_get_contents($image), 'public');
            if($old_image)
                Storage::delete($module.'s/'.$old_image);
        }
        $this->data->image = $image_name;

        //video upload function
        if($request->video)
        {
            $video = $request->video;
            $video_name = 'slider_'.time().'.'.$video->getClientOriginalExtension();
            $video_path = $module.'s/'.$video_name;
            Storage::put($video_path, file_get_contents($video), 'public');
            if($old_video)
                Storage::delete($module.'s/'.$old_video);
        }
        $this->data->video = $video_name;

        $request->status == 1 ? $this->data->status = 1 : $this->data->status = 0;
        $this->data->save();
        $dataId = $this->data->id;

        //Image upload function
        $files = Input::file('photo.image');
        if($files){
            $images = null; $i = 0;
            foreach ($files as $file) {
                $i++;
                // Image::make($file)->widen(1400)->save($file);
                // Image::make($file)->widen(1920, function ($constraint) {$constraint->upsize(); })->crop(1920,700)->fill('#ebebeb', 0, 0)->save($file);
                Image::make($file)
                ->fit(1920, 500, function ($constraint) {
                    $constraint->upsize();
                })
                ->save($file);
                $filename = $i.'_'.time().'.'.$file->getClientOriginalExtension();
                $filepath = $module.'s/'.$filename;
                $upload_success = Storage::put($filepath, file_get_contents($file), 'public');
                if($upload_success) {
                    $images[] = [
                        'order' => $i,
                        'image' => $filename,
                        'slider_id' => $dataId,
                        'created_at' => new DateTime,
                        'updated_at' => new DateTime,
                    ];
                }
            }
            if($images) {
                $this->photo->insert($images);
            }
        }

        return redirect('admin/'.$module.'s')->with('success', 'Your data has been updated successfully');
    }

    public function data_delete($data, $id)
    {
        $module = $this->module;
        $deleteData = $this->data->find($id);

        if($deleteData) {
            if($data == "image"){
                Storage::delete($module.'s/'.$deleteData->image);
                Slider::where('id', $id)->update(['image'=>""]);
            }elseif($data == "video"){
                Storage::delete($module.'s/'.$deleteData->video);
                Slider::where('id', $id)->update(['video'=>""]);
            }
            return redirect()->back()->with('success', 'Data has been deleted successfully.');
        }else {
            return redirect()->back()->with('error', 'Data has not been deleted.');
        }
    }

    public function photo_update(Request $request, $id)
    {
        $this->photo = $this->photo->find($id);
        $this->photo->fill($request->all());
        $this->photo->save();

        return redirect('admin/sliders#slide')->with('success', 'Data has been updated successfully.');
    }

    public function photo_delete($id)
    {
        $module = $this->module;

        $photo = $this->photo->find($id);
        if($photo) {
            if($photo->image)
                Storage::delete($module.'s/'.$photo->image);
            $photo->delete();
            return redirect()->back()->with('success', 'Data has been deleted successfully.');
        }else {
            return redirect()->back()->with('error', 'Data has not been deleted.');
        }
    }
}