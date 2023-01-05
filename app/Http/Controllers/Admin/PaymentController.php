<?php namespace App\Http\Controllers\Admin;

use App\Payment;
use App\Http\Requests\Admin\PaymentRequest;
use App\Http\Controllers\Controller;

class PaymentController extends Controller {

    public function __construct(Payment $payment)
    {
        $this->module = "order";
        $this->payment = $payment;

        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $module = $this->module;
        $allData = $this->payment->orderBy('id', 'DESC')->get();

        if($id) {
            $singleData = $this->payment->find($id);
        }else {
            $singleData = $this->payment;
        }

        return view('admin.'.$module.'.payment', compact('allData', 'singleData', 'module'));
    }

    public function post_add(PaymentRequest $request)
    {
        $this->payment->fill($request->all());
        $this->payment->status = 1;
        $this->payment->save();

        $sessionMsg = $this->payment->title;
        return redirect('admin/payments')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function post_edit(PaymentRequest $request, $id)
    {
        $this->payment = $this->payment->find($id);
        $this->payment->fill($request->all());
        $request->status == 1 ? $this->payment->status = 1 : $this->payment->status = 0;
        $this->payment->save();

        $sessionMsg = $this->payment->name;
        return redirect('admin/payments')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function get_delete($id)
    {
        if($this->payment->find($id)->delete()) {
            return redirect('admin/payments')->with('success', 'Your data has been deleted successfully.');
        }
        else {
            return redirect('admin/payments')->with('error', 'Your data has not been deleted.');
        }
    }
}