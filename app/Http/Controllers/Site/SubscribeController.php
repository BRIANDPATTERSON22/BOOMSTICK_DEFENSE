<?php namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\ProductNotification;
use App\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscribeController extends Controller
{
    public function __construct(Subscribe $subscribe)
    {
        $this->subscribe = $subscribe;
        $this->middleware('guest');
    }

    public function post_subscribe(Request $request)
    {
        // dd($request->all());
        $validationRule = ['email' => 'required|email|unique:subscribe,email'];
        $validation = Validator::make($request->all(), $validationRule);

        if($validation->passes()) {
            $this->subscribe->fill($request->all());
            $this->subscribe->save();
            return redirect()->back()->with('success', 'Thank You, Your have successfully subscribed to our Newsletter !');
        }else{
            return redirect()->back()->with('error', 'You are already subscribed to our newsletter. Thank you !');
        }
    }

    public function post_product_notification(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'notification_email' => 'required|email',
        ]);

        $productNotification = new ProductNotification;
        $productNotification->title = $request->title;
        $productNotification->product_id = $id;
        // $productNotification->product_id = $request->type == 1 ? $id : null;
        // $productNotification->rsr_product_id = $request->type == 0 ? $id : null;
        $productNotification->email = $request->notification_email;
        $productNotification->store_type = $request->store_type;
        $productNotification->status = 0;
        $productNotification->save();

        return redirect()->back()->with('success', 'Thank You. You will be notified when product is available.');
    }
}