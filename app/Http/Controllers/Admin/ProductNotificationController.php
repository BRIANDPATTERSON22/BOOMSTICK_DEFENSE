<?php namespace App\Http\Controllers\Admin;

use App\ProductNotification;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ProductNotificationController extends Controller
{
    public function __construct(ProductNotification $productNotification)
    {
        $this->data = $productNotification;
        $this->module = "product-notification";
    }

    public function get_index()
    {
        $year = date('Y');
        $deleteCount = $this->data->onlyTrashed()->count();
        $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->get();

        return view('admin.'.$this->module.'.index', compact('allData', 'deleteCount', 'year'));
    }

    public function get_archive($year)
    {
        $deleteCount = $this->data->onlyTrashed()->count();
        $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->get();

        return view('admin.'.$this->module.'.index', compact('allData','deleteCount', 'year'));
    }

    public function get_export_csv()
    {
        $allData = $this->data->orderBy('id', 'DESC')->get();

        Excel::create('ProductNotification', function($excel) use ($allData) {
            $excel->sheet('ProductNotification', function($sheet) use ($allData) {
                $sheet->loadView('admin.'.$this->module.'.excel', compact('allData'));
            });
        })->download('csv');
    }

    public function get_trash()
    {
        $allData = $this->data->onlyTrashed()->get();
        return view('admin.'.$this->module.'.index', compact('allData'));
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

    // public function send_bulk_mail()
    // {
    //     // Rsr Products
    //     $rsrProducts = $this->data->where('store_type', 1)->;

    //     // Boomstick Product

    //     // Sending mail
    // }
}