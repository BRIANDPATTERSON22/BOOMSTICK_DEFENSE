<?php namespace App\Http\Controllers\Admin;


use Auth;
use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CompanyController extends Controller
{
    public function __construct(Company $company)
    {
        $this->module = "company";
        $this->data = $company;

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

    public function post_add(CompanyRequest $request)
    {
        $module = $this->module;

        //Image save function
        $filename = null;
        if($request->image)
        {
            $file = $request->image;
            // Image::make($file)->widen(1024)->save($file);
            // Image::make($file)->widen(600, function ($constraint) {$constraint->upsize(); })->crop(600,400)->fill('#ffffff', 0, 0)->save($file);

            $width = 360;
            $height = 200;
            $img = Image::make($file);
            if ($img->width() > $width) { 
                $img->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            if ($img->height() > $height) {
                $img->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                }); 
            }
            $img->resizeCanvas($width, $height, 'center', false, '#ffffff');
            $img->save($file);

            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = str_plural($module).'/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->data->fill($request->all());
        $this->data->image = $filename;

        $this->data->user_id = Auth::id();
        $slug = str_slug($request->title);
        $existingSlugs = $this->data->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->data->slug =$slug.$existingSlugs : $this->data->slug = $slug;

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

    public function post_edit(CompanyRequest $request, $id)
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
            // Image::make($file)->widen(600, function ($constraint) {$constraint->upsize(); })->crop(600,400)->fill('#ffffff', 0, 0)->save($file);


            $width = 360;
            $height = 200;
            $img = Image::make($file);
            if ($img->width() > $width) { 
                $img->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            if ($img->height() > $height) {
                $img->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                }); 
            }
            $img->resizeCanvas($width, $height, 'center', false, '#ffffff');
            $img->save($file);
            
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = str_plural($module).'/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete($module.'s/'.$oldFilename);
        }

        $this->data->image = $filename;
        $this->data->user_id = Auth::id();
        $slug = str_slug($request->title);
        $existingSlugs = $this->data->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->data->slug =$slug.$existingSlugs : $this->data->slug = $slug;
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
            Storage::delete(str_plural($module).'/'.$data->image);
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
                Storage::delete(str_plural($module).'/'.$data->image);
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