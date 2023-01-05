<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\ProductReview;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class ReviewController extends Controller
{
    public function __construct(ProductReview $review)
    {
        $this->data = $review;
        $this->option = Cache::get('optionCache');
        $this->loginUser = Auth::user();
        $this->middleware('auth');
    }

    public function get_index()
    {
        $year = date('Y');
        $deleteCount = $this->data->onlyTrashed()->count();
        $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->get();

        return view('admin.review.index', compact('allData', 'deleteCount', 'year'));
    }

    public function get_archive($year)
    {
        $deleteCount = $this->data->onlyTrashed()->count();
        $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->get();

        return view('admin.subscribe.index', compact('allData','deleteCount', 'year'));
    }

    public function get_trash()
    {
        $allData = $this->data->onlyTrashed()->get();
        return view('admin.review.index', compact('allData'));
    }

    public function get_view($id)
    {
        $singleData = $this->data->find($id);
        return view('admin.review.view',compact('singleData'));
    }

    public function post_approve(Request $request, $id)
    {
        $this->data = $this->data->find($id);
        $this->data->status = $request->status;
        $this->data->save();

        return redirect()->back()->with('success', 'The review from '.$this->data->name.' has been approved');
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