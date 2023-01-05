<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\Contact;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function __construct(Contact $contact)
    {
        $this->module = "contact";
        $this->data = $contact;

        $this->middleware('auth');
    }

    public function index()
    {
        $module = $this->module;
        $deleteCount = $this->data->onlyTrashed()->count();

        $allData = $this->data->orderBy('id', 'DESC')->paginate(15);

        return view('admin.'.$module.'.index', compact('allData', 'module', 'deleteCount'));
    }

    public function get_view($id)
    {
        $module = $this->module;

        $singleData = $this->data->find($id);
        $singleData->is_viewed = 1;
        $singleData->save();

        return view('admin.'.$module.'.view',compact('singleData', 'module'));
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
        if($this->data->where('id', $id)->withTrashed()->first()->forceDelete())
        {
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