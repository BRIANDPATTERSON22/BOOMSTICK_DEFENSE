<?php namespace App\Http\Controllers\Site;

use URL;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_cancelled()
    {
        Cart::instance('cart')->destroy();
        Session::forget('coupon');
        Session::forget('shipping');
        Session::forget('payment');

        return view('site.payment.cancelled');
    }

    public function get_successful($api = null, $orderNo = null)
    {
        return redirect('site.payment.successful');
    }

    public function get_successfulMessage()
    {
        return view('site.payment.successful');
    }

    public function paypal_pay($data = [], $orderNo)
    {
        // PayPal settings
        $paypal_email = "bcurtiss@bucks4x4.com";

        $random_api = Session::get('random_api');

        $return_url = URL::to('payment-successful/'.$random_api.'/'.$orderNo);
        $cancel_url = URL::to('payment-cancelled');
        $notify_url = URL::to('payments');
        $currency_code = 'USD';

        $querystring = '';

        // Firstly Append paypal account to querystring
        $querystring .= "?business=".urlencode($paypal_email)."&";

        //Default value
        $querystring .= "cmd=".urlencode(stripslashes('_cart'))."&";
        $querystring .= "upload=".urlencode(stripslashes('1'))."&";
        $querystring .= "currency_code=".urlencode(stripslashes($currency_code))."&";
        $querystring .= "charset=".urlencode(stripslashes('utf-8'))."&";

        // Check if paypal request or response
        if (isset($data)) {
            //loop for posted values and append to querystring
            foreach($data as $key => $value){
                $value = urlencode(stripslashes($value));
                $querystring .= "$key=$value&";
            }
        }

        // Append paypal return addresses
        $querystring .= "success=".urlencode(stripslashes($return_url))."&";
        $querystring .= "return=".urlencode(stripslashes($return_url))."&";
        $querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
        $querystring .= "notify_url=".urlencode($notify_url);

        // Redirect to paypal IPN
        header('location:https://www.paypal.com/cgi-bin/webscr'.$querystring);
        //header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
        exit();
    }
}