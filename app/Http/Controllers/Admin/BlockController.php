<?php namespace App\Http\Controllers\Admin;

use Auth;
use DateTime;
use App\Block;
use App\Upload;
use App\Http\Requests\Admin\BlockRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class BlockController extends Controller
{
    public function __construct(Block $block, Upload $upload)
    {
        $this->module = "block";
        $this->data = $block;
        $this->upload = $upload;

        $this->option = Cache::get('optionCache');
        $this->middleware('auth');
    }

    public function get_index()
    {
        $module = $this->module;
        $allData = $this->data->orderBy('id', 'DESC')->get();

        return view('admin.'.$module.'.index', compact('allData', 'module', 'deleteCount'));
    }

    public function get_add()
    {
        $module = $this->module;
        $singleData = $this->data;

        return view('admin.'.$module.'.add_edit', compact('singleData', 'module'));
    }

    public function post_add(BlockRequest $request)
    {
        $module = $this->module;
        $this->data->fill($request->all());
        $this->data->content = $request->content_value;
        $this->data->slug = str_slug($request->slug);
        $this->data->status = 1;
        $this->data->save();

        $sessionMsg = $this->data->title;
        return redirect('admin/'.$module.'s')->with('success', 'Data '.$sessionMsg.' has been created');
    }

    public function get_edit($id)
    {
        $module = $this->module;
        $singleData = $this->data->find($id);

        return view('admin.'.$module.'.add_edit',compact('singleData', 'module'));
    }

    public function post_edit(blockRequest $request, $id)
    {
        $module = $this->module;

        $this->data = $this->data->find($id);
        $this->data->fill($request->all());
        $this->data->slug = str_slug($request->slug);
        $this->data->content = $request->content_value;
        $request->status == 1 ? $this->data->status = 1 : $this->data->status = 0;
        $this->data->save();

        $sessionMsg = $this->data->title;
        return redirect('admin/'.$module.'s')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function get_delete($id)
    {
        if($this->data->find($id)->delete()) {
            return redirect()->back()->with('success', 'Your data has been deleted');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been deleted.');
        }
    }


    //Upload media
    public function get_media()
    {
        $module = $this->module;
        $singleData = $this->upload;
        $singleData->photo = null;

        $year = date('Y');
        $allData = $this->upload->where('created_at', 'like', $year.'%')->get();

        return view('admin.'.$module.'.media', compact('module', 'allData', 'singleData', 'year'));
    }

    public function get_media_archive($year)
    {
        $module = $this->module;
        $singleData = $this->upload;
        $singleData->photo = null;

        $allData = $this->upload->where('created_at', 'like', $year.'%')->get();

        return view('admin.'.$module.'.media', compact('module', 'allData', 'singleData', 'year'));
    }

    public function post_media(Request $request)
    {
        $files = Input::file('photo.image');
        if(!$files) {
            return redirect()->back()->with('error', 'Please select images');
        }
        $images = null;
        $i = 0;
        foreach($files as $file) {
            $i++;
            Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
            $filename = $i.'_'.time().'.'.$file->getClientOriginalExtension();
            $filepath = 'uploads/'.$filename;
            $upload_success = Storage::put($filepath, file_get_contents($file), 'public');
            if($upload_success) {
                $images[] = [
                    'image' => $filename,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ];
            }
        }
        $this->upload->insert($images);

        return redirect()->back()->with('success', 'Upload success !');
    }

    public function get_media_delete($id)
    {
        $data = $this->upload->find($id);
        if($data) {
            Storage::delete('uploads/'.$data->image);
            $data->delete();
            return redirect()->back()->with('success', 'Your data has deleted');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been deleted.');
        }
    }
}