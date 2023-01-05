<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\Subscribe;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class SubscribeController extends Controller
{
    public function __construct(Subscribe $subscribe)
    {
        $this->data = $subscribe;
        $this->middleware('auth');
    }

    public function get_index()
    {
        $year = date('Y');
        $deleteCount = $this->data->onlyTrashed()->count();
        $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->get();

        return view('admin.subscribe.index', compact('allData', 'deleteCount', 'year'));
    }

    public function get_archive($year)
    {
        $deleteCount = $this->data->onlyTrashed()->count();
        $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->get();

        return view('admin.subscribe.index', compact('allData','deleteCount', 'year'));
    }

    public function get_export_csv()
    {
        $allData = $this->data->orderBy('id', 'DESC')->get();

        Excel::create('Subscribers', function($excel) use ($allData) {
            $excel->sheet('Subscribers', function($sheet) use ($allData) {
                $sheet->loadView('admin.subscribe.excel', compact('allData'));
            });
        })->download('csv');
    }

    public function get_trash()
    {
        $allData = $this->data->onlyTrashed()->get();
        return view('admin.subscribe.index', compact('allData'));
    }

    public function soft_delete($id)
    {
        if($this->data->find($id)->delete()) {
            return redirect()->back()->with('success', 'Your data has been moved to trash');
        }else {
            return redirect()->back()->with('error', 'Your data has not been moved to trash.');
        }
    }

    public function get_restore($id)
    {
        if($this->data->where('id', $id)->withTrashed()->first()->restore()) {
            return redirect()->back()->with('success', 'Your data has been restored.');
        }else {
            return redirect()->back()->with('error', 'Your data has not been restored.');
        }
    }

    public function force_delete($id)
    {
        if($this->data->where('id', $id)->withTrashed()->first()->forceDelete()) {
            return redirect()->back()->with('success', 'Your data has been permanently deleted');
        }else {
            return redirect()->back()->with('error', 'Your data has not been permanently deleted.');
        }
    }
}