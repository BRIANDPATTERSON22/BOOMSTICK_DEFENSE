<?php namespace App\Http\Controllers\Admin;


use Auth;
use App\Http\Requests\Admin\OurServicesRequest;
use App\OurServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class OurServicesController extends Controller
{
    public function __construct(OurServices $ourServices)
    {
        $this->module = "our-service";
        $this->data = $ourServices;

        $this->option = Cache::get('optionCache');
        $this->middleware('auth');
    }

    public function index()
    {
        $module = $this->module;
        $deleteCount = $this->data->onlyTrashed()->count();

        $allData = $this->data->orderBy('id', 'DESC')->paginate(15);

        return view('admin.'.$module.'.index', compact('allData', 'module','deleteCount'));
    }

    public function get_add()
    {
        $module = $this->module;

        $singleData = $this->data;

        return view('admin.'.$module.'.add_edit', compact('singleData', 'module'));
    }

    public function post_add(OurServicesRequest $request)
    {
        $module = $this->module;

        //Image save function
        $filename = null;
        if($request->image)
        {
            $file = $request->image;
            // Image::make($file)->widen(1024)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = $module.'s/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->data->fill($request->all());
        $this->data->image = $filename;
        $this->data->status = 1;
        $this->data->save();

        $dataId = $this->data->id;
        $sessionMsg = $this->data->brand_name;
        return redirect('admin/'.$module.'/'.$dataId.'/view')->with('success', 'Data '.$sessionMsg.' has been created');
    }

    public function get_edit($id)
    {
        $module = $this->module;

        $singleData = $this->data->find($id);

        return view('admin.'.$module.'.add_edit',compact('singleData', 'module'));
    }

    public function post_edit(OurServicesRequest $request, $id)
    {
        $module = $this->module;

        $this->data = $this->data->find($id);
        $oldFilename = $filename = $this->data->image;
        $this->data->fill($request->all());
        $request->status == 1 ? $this->data->status = 1 : $this->data->status = 0;

        //Image upload function
        if($request->image)
        {
            $file = $request->image;
            // Image::make($file)->widen(1024)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = $module.'s/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete($module.'s/'.$oldFilename);
        }

        $this->data->image = $filename;
        $this->data->save();

        $sessionMsg = $this->data->title;
        return redirect('admin/'.$module.'/'.$id.'/view')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function get_view($id)
    {
        $module = $this->module;

        $singleData = $this->data->find($id);

        return view('admin.'.$module.'.view',compact('singleData', 'module'));
    }

    public function image_delete($id)
    {
        $module = $this->module;

        $data = $this->data->find($id);
        if($data)
        {
            Storage::delete($module.'s/'.$data->image);
            $data->update(['image'=>'']);
            return redirect()->back()->with('success', 'The image has been deleted successfully.');
        }
        else
        {
            return redirect()->back()->with('error', 'The image has not been deleted.');
        }
    }

    public function soft_delete($id)
    {
        if($this->data->find($id)->delete())
        {
            return redirect()->back()->with('success', 'Your data has been moved to trash');
        }
        else
        {
            return redirect()->back()->with('error', 'Your data has not been moved to trash.');
        }
    }

    public function get_restore($id)
    {
        if($this->data->where('id', $id)->withTrashed()->first()->restore())
        {
            return redirect()->back()->with('success', 'Your data has been restored.');
        }
        else
        {
            return redirect()->back()->with('error', 'Your data has not been restored.');
        }
    }

    public function force_delete($id)
    {
        $module = $this->module;
        $data = $this->data->where('id', $id)->withTrashed()->first();
        if($data)
        {
            if($data->image)
                Storage::delete($module.'s/'.$data->image);
            $data->forceDelete();
            return redirect()->back()->with('success', 'Your data has been permanently deleted');
        }
        else
        {
            return redirect()->back()->with('error', 'Your data has not been permanently deleted.');
        }
    }

    public function get_trash()
    {
        $module = $this->module;

        $allData = $this->data->onlyTrashed()->paginate(15);

        return view('admin.'.$module.'.index', compact('allData', 'module'));
    }
}