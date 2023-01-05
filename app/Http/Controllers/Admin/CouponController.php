<?php namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use App\Coupon;
use App\Subscribe;
use App\Customer;
use App\Http\Requests\Admin\CouponRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class CouponController extends Controller {

    public function __construct(Coupon $coupon)
    {
        $this->data = $coupon;

        $this->option = Cache::get('optionCache');
        $this->loginUser = Auth::user();
        $this->middleware('auth');
    }

    public function get_index()
    {
        $year = date('Y');
        $deleteCount = $this->data->onlyTrashed()->count();
        $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->get();

        return view('admin.coupon.index', compact('allData', 'deleteCount', 'year'));
    }

    public function get_archive($year)
    {
        $deleteCount = $this->data->onlyTrashed()->count();
        $allData = $this->data->where('created_at', 'like', $year.'%')->orderBy('id', 'DESC')->get();

        return view('admin.coupon.index', compact('allData','deleteCount', 'year'));
    }

    public function get_trash()
    {
        $allData = $this->data->onlyTrashed()->get();
        return view('admin.coupon.index', compact('allData'));
    }

    public function get_add()
    {
        //Series number & Pin number generator
        $series_no = substr( md5(rand()), 0, 15);
        $pin_no = rand(10000000, 99999999);
        while (count($this->data->where('series_no', $series_no)->where('pin_no', $pin_no)->get()) > 0) {
            $series_no = substr( md5(rand()), 0, 15);
            $pin_no = rand(10000000, 99999999);
        }
        //End generator

        $singleData  = new Coupon();
        $series     = $series_no;
        $pin        = $pin_no;

        return view('admin.coupon.add_edit',compact('singleData','series','pin'));
    }

    public function post_add(CouponRequest $request)
    {
        $this->data->fill($request->all());
        $this->data->user_id = $this->loginUser->id;
        $this->data->status = 1;
        $this->data->save();
        $dataId = $this->data->id;

        $sessionMsg = $this->data->name;
        return redirect('admin/coupon/'.$dataId.'/view')->with('success', 'Coupon '.$sessionMsg.' has been created');
    }

    public function get_edit($id)
    {
        $singleData  = $this->data->find($id);
        $series     = $this->data->series_no;
        $pin        = $this->data->pin_no;

        return view('admin.coupon.add_edit', compact('singleData', 'series', 'pin'));
    }

    public function post_edit(CouponRequest $request, $id)
    {
        $this->data = $this->data->find($id);
        $this->data->fill($request->all());
        $request->status == 1 ? $this->data->status = 1 : $this->data->status = 0;
        $this->data->save();

        $sessionMsg = $this->data->name;
        return redirect('admin/coupon/'.$id.'/view')->with('success', 'Coupon '.$sessionMsg.' has been updated ');
    }

    public function get_view($id)
    {
        $singleData = $this->data->find($id);

        return view('admin.coupon.view',compact('singleData'));
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


    //Email blahed
    public function get_send_guests($id)
    {
        $option = $this->option;
        $singleData = $this->data->find($id);

        $customers = Customer::select('customer.*', 'user.email')
            ->join('user', 'customer.user_id', '=', 'user.id')
            ->get();
        if(count($customers)>0) {
            foreach ($customers as $row) {
                if($row->email) {
                    $data = [
                        'coupon' => $singleData->name,
                        'code' => $singleData->series_no,
                        'date' => $singleData->start_date . ' - ' . $singleData->expiry_date,
                        'discount' => $singleData->percentage,
                        'name' => $row->first_name. ' ' .$row->last_name,
                        'email' => $row->email,
                        'siteEmail' => $option->email,
                        'siteName' => $option->name,
                    ];

                    Mail::send('emails.coupon.newsletter', $data, function ($message) use ($data) {
                        $message->subject('Offer - ' . $data['siteName'])
                            ->to($data['email'], $data['name']);
                    });
                }
            }
        }

        return redirect()->back()->with('info', 'A offer newsletter emails has been send to the subscribers');
    }

    public function get_send_subscribers($id)
    {
        $option = $this->option;
        $singleData = $this->data->find($id);

        $subscribers = Subscribe::get();
        if(count($subscribers)>0) {
            foreach ($subscribers as $row) {
                if($row->email) {
                    $data = [
                        'coupon' => $singleData->name,
                        'code' => $singleData->series_no,
                        'date' => $singleData->start_date . ' - ' . $singleData->expiry_date,
                        'discount' => $singleData->percentage,
                        'name' => $row->email,
                        'email' => $row->email,
                        'siteEmail' => $option->email,
                        'siteName' => $option->name,
                    ];

                    Mail::send('emails.coupon.newsletter', $data, function ($message) use ($data) {
                        $message->subject('Offer - ' . $data['siteName'])
                            ->to($data['email'], $data['name']);
                    });
                }
            }
        }

        return redirect()->back()->with('info', 'A offer newsletter emails has been send to the subscribers');
    }
}