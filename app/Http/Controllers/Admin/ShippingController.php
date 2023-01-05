<?php namespace App\Http\Controllers\Admin;

use App\Shipping;
use App\Http\Requests\Admin\ShippingRequest;
use App\Http\Controllers\Controller;

class ShippingController extends Controller {

    public function __construct(Shipping $shipping)
    {
        $this->module = "order";
        $this->shipping = $shipping;

        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $module = $this->module;
        $allData = $this->shipping->orderBy('id', 'DESC')->get();

        if($id) {
            $singleData = $this->shipping->find($id);
        }else {
            $singleData = $this->shipping;
        }

        return view('admin.'.$module.'.shipping', compact('allData', 'singleData', 'module'));
    }

    public function post_add(ShippingRequest $request)
    {
        $this->shipping->fill($request->all());
        $this->shipping->status = 1;
        $this->shipping->save();

        $sessionMsg = $this->shipping->title;
        return redirect('admin/shippings')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function post_edit(ShippingRequest $request, $id)
    {
        $this->shipping = $this->shipping->find($id);
        $this->shipping->fill($request->all());
        $request->status == 1 ? $this->shipping->status = 1 : $this->shipping->status = 0;
        
        $this->shipping->save();

        $sessionMsg = $this->shipping->name;
        // return redirect('admin/shippings')->with('success', 'Data '.$sessionMsg.' has been updated');
        return redirect()->back()->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function get_delete($id)
    {
        if($this->shipping->find($id)->delete()) {
            return redirect('admin/shippings')->with('success', 'Your data has been deleted successfully.');
        }
        else {
            return redirect('admin/shippings')->with('error', 'Your data has not been deleted.');
        }
    }
}