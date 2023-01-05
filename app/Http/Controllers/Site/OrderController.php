<?php namespace App\Http\Controllers\Site;

use App\Country;
use App\Coupon;
use App\Customer;
use App\CustomerPaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Site\CheckoutAddresRequest;
use App\Option;
use App\Order;
use App\OrderItem;
use App\Payment;
use App\Product;
use App\RsrProduct;
use App\SalesPerson;
use App\SalesPersonHasStore;
use App\Shipping;
use App\StoreManager;
use App\StoreManagerHasStore;
use Carbon\Carbon;
use DB;
use DateTime;
use FedEx\CloseService\SimpleType\LinearUnits;
use FedEx\CourierDispatchService\SimpleType\WeightUnits;
use FedEx\InFlightShipmentService\SimpleType\PaymentType;
use FedEx\OpenShipService\ComplexType\RequestedPackageLineItem;
use FedEx\OpenShipService\SimpleType\RateRequestType;
use FedEx\RateService\ComplexType\RateRequest;
use FedEx\RateService\Request as FedExREquest;
use Gloudemans\Shoppingcart\Facades\Cart;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\TransferStats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Omnipay\Common\CreditCard;
use Omnipay\Omnipay;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment as PaymentP;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use SagePay;
use URL;

class OrderController extends Controller
{
    private $_api_context;

    public function __construct(
        Country $country,
        Customer $customer,
        Product $product,
        Order $order, OrderItem $orderItem,
        Shipping $shipping, Payment $payment, Coupon $coupon, CustomerPaymentMethod $customerPaymentMethod, SalesPerson $salesPerson, SalesPersonHasStore $salesPersonHasStore, StoreManager $storeManager, StoreManagerHasStore $storeManagerHasStore, RsrProduct $rsrProduct)
    {
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

        $this->country = $country;
        $this->customer = $customer;
        $this->product = $product;
        $this->order = $order;
        $this->orderItem = $orderItem;
        $this->shipping = $shipping;
        $this->payment = $payment;
        $this->coupon = $coupon;
        $this->customerPaymentMethod = $customerPaymentMethod;
        $this->salesPerson = $salesPerson;
        $this->salesPersonHasStore = $salesPersonHasStore;
        $this->storeManager = $storeManager;
        $this->storeManagerHasStore = $storeManagerHasStore;
        $this->rsrProduct = $rsrProduct;
        $this->middleware('auth');

        $this->option = Cache::get('optionCache');
        $this->loggedInCustomer = $this->customer->where('user_id', Auth::id())->first();
    }

    function order_number()
    {
        $latest = Order::latest()->withTrashed()->first();
        if (! $latest) {
            return '10001';
        }
        return $latest->order_no + 1 ;
    }

    public function get_total_weight()
    {
        $cartItems = Cart::instance('cart')->content();
        $totalWeight = 0;
        if ($cartItems->count() > 0) {
            foreach ($cartItems as $item) {
                $totalWeightArr[] = $item->options['weight'] * $item->qty;
            }
            return array_sum($totalWeightArr);
        }
    }

    public function boomstick_product_count()
    {
        $boomstickProductCount = Cart::instance('cart')->content()->where('options.type', 0)->count();
        return $boomstickProductCount > 0 ? true : false;
    }

    public function rsr_product_count()
    {
        $rsrProductCount = Cart::instance('cart')->content()->where('options.type', 1)->count();
        return $rsrProductCount > 0 ? true : false;
    }

    public function customer_id()
    {
        return Auth::user()->customer ? Auth::user()->customer->id : NULL;
    }

    public function customer_data()
    {
        return $this->customer->where('user_id', Auth::id())->first();
    }


    // 0.1
    public function get_guest_checkout_verification()
    {
        if (Cart::instance('cart')->count() == 0) {
            abort(404);
        }

        if(Cart::instance('cart')->content()->where('options.is_age_verification_required', 1)->count() == 0){
            return redirect('checkout-address');
        }

        return view('site.order.age_verification');
    }

    public function post_guest_checkout_verification(Request $request)
    {
        Session::put('ageVerificationSession', 'verified');
        return redirect('checkout-address');
    }

    public function get_guest_checkout_remove_products()
    {
       // remove under age products
        $cartItems = Cart::instance('cart')->content();
        if ($cartItems->count() > 0) {
            foreach ($cartItems as $item) {
                if ($item->options['is_age_verification_required'] == 1) {
                    Cart::instance('cart')->remove($item->rowId);
                }
            }
        }

        if (Cart::instance('cart')->content()->count() > 0) {
            return redirect('checkout-address');
        }else{
            return redirect('products')->with('error', 'Products has been removed from your cart!');
        }
    }

    // 0.2
    public function get_guest_checkout_state_verification()
    {
        if (Cart::instance('cart')->count() == 0) {
            abort(404);
        }

        if (!session()->has('stateSession')) {
            return redirect('checkout-address')->with('error', 'Please, Enter your address');
        }

        if (session('stateSession') == "id") {
            $stateSessionData = "id_idaho";
        }else{
            $stateSessionData = session('stateSession');
        }

        return view('site.order.state_verification', compact('stateSessionData'));
    }

    public function post_guest_checkout_state_verification(Request $request)
    {
        // dd(session('stateSession'));
        // $stateSessionData = session('stateSession');

        if (session('stateSession') == "id") {
            $stateSessionData = "id_idaho";
        }else{
            $stateSessionData = session('stateSession');
        }

        if (Cart::instance('cart')->count() == 0) {
            abort(404);
        }

        if (!session()->has('stateSession')) {
            return redirect('checkout-address')->with('error', 'Please, Enter your address');
        }

        $cartItems = Cart::instance('cart')->content();
        if ($cartItems->count() > 0) {
            foreach ($cartItems as $item) {
                if($item->options['type'] == 0){
                    // dump('local', $this->product->where('status', 1)->where('slug', $item->options['slug'])->first()->$stateSessionData);
                    if ($this->product->where('status', 1)->where('slug', $item->options['slug'])->first()->$stateSessionData == 'Y') {
                        Cart::instance('cart')->remove($item->rowId);
                    }
                }else{
                    // dump('rsr', $this->rsrProduct->where('rsr_stock_number', $item->options['id'])->first()->session('stateSession'));
                    if ($this->rsrProduct->where('rsr_stock_number', $item->options['slug'])->first()->$stateSessionData == 'Y') {
                        Cart::instance('cart')->remove($item->rowId);
                    }
                }
            }
        }

        if (Cart::instance('cart')->content()->count() > 0) {
            if (Cart::instance('cart')->content()->where('options.is_firearm', 1)->count() > 0) {
                return redirect('checkout-ffl-dealers');
            }else{
                return redirect('checkout-shipping');
            }
        }else{
            return redirect('products')->with('error', 'Products has been removed from your cart!');
        }

        // return redirect('shipping-methods');
    }

    // public function get_guest_checkout_remove_state_products()
    // {
    //     $cartItems = Cart::instance('cart')->content();
    //     if ($cartItems->count() > 0) {
    //         foreach ($cartItems as $item) {
    //             if ($item->options['is_age_verification_required'] == 1 || $item->options['is_firearm'] == 1) {
    //                 Cart::instance('cart')->remove($item->rowId);
    //             }
    //         }
    //     }
    //     return redirect('address');
    // }

    // 0.3
    public function get_guest_ffl_dealer()
    {
        if (Cart::instance('cart')->count() == 0) {
            abort(404);
        }

        if (!session()->has('stateSession')) {
            return redirect('checkout-address')->with('error', 'Please, Enter your address');
        }

        $fflDealers = (new \App\Http\Controllers\Site\RsrApiController)->get_ffl_dealers();

        return view('site.order.ffl_dealer', compact('fflDealers'));
    }

    public function post_guest_ffl_dealer(Request $request)
    {
        Session::put('fflDealerSession', $request->ffl_dealer);
        Session::put('fflLicenceSession', $request->ffl_licence);
        return redirect('checkout-shipping');
    }

    // ----------------


    public function get_checkout_address()
    {
        if (Cart::instance('cart')->count() == 0) {
            return redirect('products')->with('error', 'Your Cart is empty. Add some products');
        }

        if(Cart::instance('cart')->content()->where('options.is_age_verification_required', 1)->count() > 0){
            if (!session()->has('ageVerificationSession')) {
                return redirect('checkout-age-verification')->with('error', 'Please, Verify your age.');
            }
        }

        $customer = $this->customer->where('user_id', Auth::id())->first();
        // $countries = $this->country->pluck('nicename', 'id');
        $countries = $this->country->where('id', 226)->pluck('nicename', 'id');

        return view('site.order.address', compact('customer', 'countries'));
    }

    public function post_checkout_address(CheckoutAddresRequest $request)
    {
        $this->customer = $this->customer->where('user_id', Auth::id())->first();

        $this->customer->fill($request->all());
        if($request->is_same_as_billing == 1){
            $this->customer->delivery_address = $request->billing_address;
            $this->customer->delivery_city = $request->billing_city;
            $this->customer->delivery_state = $request->billing_state;
            $this->customer->delivery_postal_code = $request->billing_postal_code;
            $this->customer->delivery_country_id = $request->billing_country_id;
        }
        $request->is_same_as_billing == 1 ? $this->customer->is_same_as_billing = 1 : $this->customer->is_same_as_billing = 0;
        $this->customer->save();

        // Data for shipping
        $address = $request->is_same_as_billing == 1 ? $request->billing_address : $request->delivery_address;
        $city = $request->is_same_as_billing == 1 ? $request->billing_city : $request->delivery_city;
        $state = $request->is_same_as_billing == 1 ? $request->billing_state : $request->delivery_state;
        $postalCode = $request->is_same_as_billing == 1 ? $request->billing_postal_code : $request->delivery_postal_code;
        $countryId = $request->is_same_as_billing == 1 ? $request->billing_country_id : $request->delivery_country_id;

        Session::put('guestAddressSession', $request->all());
        Session::put('isSameAsBillingSession', $request->is_same_as_billing);
        Session::put('postalCodeSession', $postalCode);
        Session::put('stateSession', strtolower(substr($state, 0, 2)));

        try {
            // UPS Address Validation
            $accessKey = "2D903435D3D5C272";
            $userId = "3Y3446";
            $password = "Zompers2018!";

            $address = new \Ups\Entity\Address();
            $address->setStateProvinceCode(strtolower(substr($state, 0, 2)));
            // $address->setStateProvinceCode('NY');
            // $address->setCity('New York');
            $address->setCountryCode('US');
            $address->setPostalCode($postalCode);

            $av = new \Ups\SimpleAddressValidation($accessKey, $userId, $password);
            $response = $av->validate($address);

            if ($request->data_from == "checkout") {
                return redirect('checkout-review');
            }else{
                return redirect('checkout-state-verification');
            }
            // return redirect('checkout-shipping');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function get_checkout_shipping()
    {
        if (Cart::instance('cart')->count() == 0) {
            return redirect('products')->with('error', 'Your Cart is empty. Add some products');
        }

        if (!session()->has('stateSession')) {
            return redirect('checkout-address')->with('error', 'Please, Enter your address');
        }

        $customer = Auth::user()->customer;
        $shippingData = $this->shipping->where('status', 1)->get();

        // UPS Shipping method
        if(is_array($this->get_rating()) ){
            $rating = $this->get_rating();
        }else{
            $rating = [];
        }

        // FedEx Shipping method
        if(is_array($this->get_fedex_rating()) ){
            $fedExRating = $this->get_fedex_rating();
        }else{
            $fedExRating = [];
        }

        $shippingServices = array_merge($rating, $fedExRating);

        return view('site.order.shipping', compact('shippingData', 'rating', 'fedExRating', 'shippingServices'));
    }

    public function post_checkout_shipping(Request $request)
    {
        try {
            $mainShippingId = $request->main_shipping_method;
            $subShippingId = $request->sub_shipping_method;
            $subShippingAmount = $request->sub_shipping_method_price;
            $subShippingServiceName = $request->sub_shipping_method_service_name;
            $singleShippingData = $this->shipping->find($mainShippingId);

            Session::put('shippingSingleDataSession', $singleShippingData);
            Session::put('mainShippingIdSession', $mainShippingId);
            Session::put('mainShippingAmountSession', $singleShippingData->amount);
            Session::put('mainShippingMethodSession', $singleShippingData->title);
            Session::put('subShippingIdSession', $subShippingId);
            Session::put('subShippingAmountSession', $subShippingAmount);
            Session::put('subShippingServiceNamesSession', $subShippingServiceName);

            if ($request->data_from == "checkout") {
                return redirect('checkout-review');
            }else{
                return redirect('checkout-payment');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function get_checkout_payment()
    {
        if (Cart::instance('cart')->count() == 0) {
            abort(404);
        }

        if (!session()->has('stateSession')) {
            return redirect('checkout-address')->with('error', 'Please, Enter your address');
        }

        if (!session()->has('shippingSingleDataSession')) {
            return redirect('checkout-shipping')->with('error', 'Please, Select a shipping method.');
        }

        $payments = $this->payment->where('status', 1)->get();
        return view('site.order.payment', compact('payments'));
    }

    public function post_checkout_payment(Request $request)
    {
        $validator = Validator::make($request->all(), ['payment_method' => 'required']);
        if ($validator->fails()) { return redirect()->back()->withErrors($validator)->withInput();}

        $paymentId = $request->payment_method;
        $paymentData = $this->payment->find($paymentId);

        Session::put('paymentSingleDataSession', $paymentData);
        Session::put('paymentMethodSession', $paymentData->title);
        Session::put('paymentIdSession', $paymentId);

        return redirect('checkout-review');
    }

    public function get_checkout_review()
    {
        if (Cart::instance('cart')->count() == 0) {
            abort(404);
        }

        // if (!session()->has('stateSession')) {
        //     return redirect('checkout-address')->with('error', 'Please, Enter your address');
        // }

        // if (!session()->has('shippingSingleDataSession')) {
        //     return redirect('checkout-shipping')->with('error', 'Please, select your shipping method.')->withInput();
        // }

        // if (!session()->has('paymentSingleDataSession')) {
        //     return redirect('checkout-payment')->with('error', 'Please, select your payment method.')->withInput();
        // }

        $customerData = Session::get('guestAddressSession');
        $isSameAsBilling = Session::get('isSameAsBillingSession');
        $mainShippingId = Session::get('mainShippingIdSession');
        $subShippingId = Session::get('subShippingIdSession');
        $shippingAmount = Session::get('subShippingAmountSession');
        $rsrShippingAmount = Session::get('mainShippingAmountSession');
        $shippingServiceName = Session::get('subShippingServiceNamesSession');
        $paymentMethod = Session::get('paymentMethodSession');
        $paymentId = Session::get('paymentIdSession');
        $mainShippingMethod = Session::get('mainShippingMethodSession');

        // --
        $cartItems = Cart::instance('cart')->content();
        $itemPrice[] = 0;
        $itemRsrShippingAmount[] = 0;
        foreach ($cartItems as $item) {
            $itemPrices[] = $item->qty * $item->price;
            if($item->options['type'] == 1){
                $itemRsrShippingAmount[] = $item->qty * $rsrShippingAmount;
            }
        }

        $totalRsrShippingAMount = array_sum($itemRsrShippingAmount);
        $subTotal = array_sum($itemPrices);
        // $grandTotal = $subTotal + $shippingAmount + $totalRsrShippingAMount;

        // Grand Total
        if ($this->boomstick_product_count() && $this->rsr_product_count()) {
            $grandTotal = $subTotal + $shippingAmount + $totalRsrShippingAMount;
        }elseif($this->boomstick_product_count()){
            $totalRsrShippingAMount = 0;
            $grandTotal = $subTotal + $shippingAmount;
        }elseif($this->rsr_product_count()){
            $shippingAmount = 0;
            $grandTotal = $subTotal + $totalRsrShippingAMount;
        }

        // Single Page Checkout
        $customer = $this->loggedInCustomer;
        $countries = $this->country->where('id', 226)->pluck('nicename', 'id');
        $shippingData = $this->shipping->where('status', 1)->get();
        $payments = $this->payment->where('status', 1)->get();

        // UPS Shipping method
        if(is_array($this->get_rating()) ){
            $rating = $this->get_rating();
        }else{
            $rating = [];
        }

        // FedEx Shipping method
        if(is_array($this->get_fedex_rating()) ){
            $fedExRating = $this->get_fedex_rating();
        }else{
            $fedExRating = [];
        }

        // Total Shipping services
        $shippingServices = array_merge($rating, $fedExRating);

        return view('site.order.review_style_1', compact('cartItems', 'subTotal', 'shippingAmount', 'totalRsrShippingAMount', 'grandTotal', 'mainShippingMethod', 'shippingServiceName', 'paymentMethod', 'customer', 'countries', 'shippingData', 'payments', 'rating', 'fedExRating', 'shippingServices'));
    }

    public function post_checkout_review(Request $request)
    {
        if (Cart::instance('cart')->count() == 0) {
            return redirect('cart')->with('Your cart is empty.');
        }

        if (!session()->has('stateSession')) {
            return redirect()->back()->with('error', 'Please, Enter your address.')->withInput();
        }
        
        if (!session()->has('shippingSingleDataSession')) {
            return redirect()->back()->with('error', 'Please, select your shipping method.')->withInput();
        }

        if (!session()->has('paymentSingleDataSession')) {
            return redirect()->back()->with('error', 'Please, select your payment method.')->withInput();
        }

        try {
            $customer = $this->loggedInCustomer;

            $customerData = Session::get('guestAddressSession');
            $isSameAsBilling = Session::get('isSameAsBillingSession');
            $mainShippingId = Session::get('mainShippingIdSession');
            $subShippingId = Session::get('subShippingIdSession');
            $shippingAmount = Session::get('subShippingAmountSession');
            $rsrShippingAmount = Session::get('mainShippingAmountSession');
            $shippingServiceName = Session::get('subShippingServiceNamesSession');
            $paymentMethod = Session::get('paymentMethodSession');
            $paymentId = Session::get('paymentIdSession');
            $fflDealerName = Session::get('fflDealerSession');
            $fflLicence = Session::get('fflLicenceSession');

            // Creating the Order
            $this->order->fill($customerData);
            $this->order->order_no = $this->order_number();
            $this->order->uuid = Str::uuid();
            $this->order->customer_id = $customer->id;
            $this->order->order_status = 1; 
            // 1.Approval pending 2. Order Approved 3. Order Rejected 4. Dispatched 5.Delivered
            $paymentId == 5 || 7 ? $this->order->payment_status = 3 : $this->order->payment_status = 1;
            // 1-UNPAID 2- PAID 3-INCOMPLETED 4-FAILED 5-ERROR
            $this->order->checkout_type = 2;
            // '1' => 'Guest', '2' => 'Customer', '3' => 'Other'
            // $this->order->shipping_amount = $shippingAmount;
            $this->order->shipping_id = $mainShippingId;
            $this->order->shipping_service_id = $subShippingId;
            $this->order->shipping_service_name = $shippingServiceName;
            $this->order->payment_id = $paymentId;
            $this->order->ffl_dealer_name = $fflDealerName;
            $this->order->ffl_licence = $fflLicence;
            $this->order->ip = $request->getClientIp();
            $this->order->timezone_identifier = $request->timezone_identifier;
            $this->order->status = 1;
            $this->order->save();
            $orderId = $this->order->id;

            // Insert Order Items
            $cartItems = Cart::instance('cart')->content();
            $orderItems = null;
            $itemPrice[] = 0;
            $itemRsrShippingAmount[] = 0;
            foreach ($cartItems as $item) {
                $orderItems[] = [
                    'order_id' => $orderId,
                    'product_id' => $item->id,
                    'product_name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $item->qty,
                    // 'discount_percentage' => $item->discount_percentage,
                    // 'image' => $item->discount_percentage,
                    'status' => 1,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ];

                $itemPrices[] = $item->qty * $item->price;

                if($item->options['type'] == 1){
                    $itemRsrShippingAmount[] = $item->qty * $rsrShippingAmount;
                }
            }
            if ($orderItems){
                $this->orderItem->insert($orderItems);
            }

            // Shipping Amounts
            $totalRsrShippingAMount = array_sum($itemRsrShippingAmount);
            // $totalShippingAmount = $shippingAmount + $totalRsrShippingAMount;

            // Total
            $subTotal =  array_sum($itemPrices);
            // $grandTotal = $subTotal + $totalShippingAmount;

            // Grand Total
            if ($this->boomstick_product_count() && $this->rsr_product_count()) {
                $grandTotal = $subTotal + $shippingAmount + $totalRsrShippingAMount;
            }elseif($this->boomstick_product_count()){
                $totalRsrShippingAMount = 0;
                $grandTotal = $subTotal + $shippingAmount;
            }elseif($this->rsr_product_count()){
                $shippingAmount = 0;
                $grandTotal = $subTotal + $totalRsrShippingAMount;
            }

            // Update the Order
            $this->order = $this->order->find($orderId);
            $this->order->bs_shipping_amount = $shippingAmount;
            $this->order->rsr_shipping_amount = $totalRsrShippingAMount;
            // $this->order->shipping_amount = $totalShippingAmount;
            $this->order->shipping_amount = $shippingAmount + $totalRsrShippingAMount;
            $this->order->sub_total = $subTotal;
            $this->order->grand_total = $grandTotal;
            $this->order->save();

            $orderNo = $this->order->order_no;

            //Emails
            $order = $this->order->find($orderId);
            $orderItems = $this->orderItem->where('order_id', $orderId)->get();
            $option = Option::first();
            $data = [
                'name' => $order->customer->first_name . ' ' . $order->customer->last_name,
                'email' => $order->customer->email,
                'siteEmail' => $option->email,
                'siteName' => $option->name,
            ];
            Session::put('order', $order);
            Session::put('orderItems', $orderItems);
            Session::put('mailData', $data);
            Session::put('orderNo', $orderNo);
            Session::put('grandTotalSesssion', $grandTotal);

            // Payment Methods
            if ($paymentId == 1){  //Pay on Delivery
                return $this->sendMail();
            }elseif ($paymentId == 5) {  // Paypal
                // return view('site.payment.paypal', compact('grandTotal'));
                return redirect('paypal');
            }elseif($paymentId == 7){
                return redirect('pay-by-authorize-net');
            }else{
               return redirect()->with('error', 'Order Failed!');
            }

            return redirect('completed')->with('success', 'Your order has been placed and you will receive an order confirmation email. Thank you.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function sendMail()
    {
        $order = Session::get('order');
        $orderItems = Session::get('orderItems');
        $data = Session::get('mailData');

        // Email to admin
        Mail::send('emails.order.request', compact('order', 'orderItems'), function ($message) use ($data) {
            $message->to($data['siteEmail'])->subject('Order Received - ' . $data['siteName']);
        });

        // Email to User
        Mail::send('emails.order.confirmation', compact('order', 'orderItems'), function ($message) use ($data) {
            $message->to($data['email'])->subject('Order Confirmation - ' . $data['siteName']);
        });

        return redirect('completed')->with('success', 'Your order has been placed and you will receive an order confirmation email. Thank you.');
    }

    public function get_paypal()
    {
        $grandTotal = Session::get('grandTotalSesssion');
        return view('site.order.paypal', compact('grandTotal'));
    }

    public function post_paypal_status(Request $request)
    {
        $this->order
            ->where('id', Session('order')['id'])
            ->update([
                'status' => 1, 
                'payment_status' => 2, 
                'paypal_payment_id' =>  $request->orderId, 
                'paypal_payer_id' => $request->payerID
            ]);

        $this->sendMail();
        
        return response()->json(['data' => true], 200);
    }

    public function get_payment_completed()
    {
        if (!Session::get('orderNo')) {
            abort(404);
        }

        $orderNo = Session::get('orderNo');

        Session::forget('order');
        Session::forget('orderNo');
        Session::forget('orderItems');
        Session::forget('mailData');

        Session::forget('ageVerificationSession');
        Session::forget('stateSession');
        Session::forget('fflDealerSession');
        Session::forget('shippingSingleDataSession');
        Session::forget('paymentSingleDataSession');
        Session::forget('paymentMethodSession');
        Session::forget('paymentIdSession');
        Session::forget('mainShippingIdSession');
        Session::forget('mainShippingAmountSession');
        Session::forget('mainShippingMethodSession');
        Session::forget('subShippingIdSession');
        Session::forget('subShippingAmountSession');
        Session::forget('subShippingServiceNamesSession');
        Session::forget('grandTotalSesssion');

        Cart::instance('cart')->destroy();

        return view('site.order.completed', compact('orderNo'));
    }

    public function get_payment_cancelled()
    {
        if(session()->has('order')){
            // Cart::instance('cart')->destroy();
            session::forget('order');
            session::forget('orderItems');
            session::forget('mailData');

            return view('site.order.cancelled');
        }

        return view('site.errors.404');    
    }

    // -----------------
    public function get_address_validate()
    {
        $postalCode = Session::get('postalCodeSession');
        
        $accessKey = "2D903435D3D5C272";
        $userId = "3Y3446";
        $password = "Zompers2018!";

        $address = new \Ups\Entity\Address();
        // $address->setStateProvinceCode('NY');
        // $address->setCity('New York');
        $address->setCountryCode('US');
        $address->setPostalCode($postalCode);

        $av = new \Ups\SimpleAddressValidation($accessKey, $userId, $password);

        try {
            $response = $av->validate($address);
            return $response;
            // dump($response);
        } catch (\Exception $e) {
            return redirect('checkout')->with('error', $e->getMessage());
        }
    }

    public function get_rating()
    {
        $postalCode = Session::get('postalCodeSession');
        $totalWeight = $this->get_total_weight();

        $accessKey = "2D903435D3D5C272";
        $userId = "3Y3446";
        $password = "Zompers2018!";

        $rate = new \Ups\Rate($accessKey, $userId,$password);

        try {
            $shipment = new \Ups\Entity\Shipment();

            $shipperAddress = $shipment->getShipper()->getAddress();
            $shipperAddress->setPostalCode('83616');

            $address = new \Ups\Entity\Address();
            $address->setPostalCode('83616');
            $shipFrom = new \Ups\Entity\ShipFrom();
            $shipFrom->setAddress($address);

            $shipment->setShipFrom($shipFrom);

            $shipTo = $shipment->getShipTo();
            $shipTo->setCompanyName('Test Ship To');
            $shipToAddress = $shipTo->getAddress();
            $shipToAddress->setPostalCode($postalCode);

            // $package = new \Ups\Entity\Package();
            // $package->getPackagingType()->setCode(\Ups\Entity\PackagingType::PT_PACKAGE);
            // $package->getPackageWeight()->setWeight($totalWeight);
            
            // // if you need this (depends of the shipper country)
            // $weightUnit = new \Ups\Entity\UnitOfMeasurement;
            // $weightUnit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_LBS);
            // $package->getPackageWeight()->setUnitOfMeasurement($weightUnit);

            // $dimensions = new \Ups\Entity\Dimensions();
            // $dimensions->setHeight(10);
            // $dimensions->setWidth(10);
            // $dimensions->setLength(10);

            // $unit = new \Ups\Entity\UnitOfMeasurement;
            // $unit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_IN);

            // $dimensions->setUnitOfMeasurement($unit);
            // $package->setDimensions($dimensions);

            // $shipment->addPackage($package);
            // // dump($rate->getRate($shipment));
            // $shopRates = $rate->shopRates($shipment);

            $cartItems = Cart::instance('cart')->content();
            if ($cartItems->count() > 0) {
                foreach ($cartItems as $item) {
                    for ($i=0; $i < $item->qty; $i++) { 
                        $package = new \Ups\Entity\Package();
                        $package->getPackagingType()->setCode(\Ups\Entity\PackagingType::PT_PACKAGE);
                        $package->getPackageWeight()->setWeight($item->options['weight']);
                        
                        // if you need this (depends of the shipper country)
                        $weightUnit = new \Ups\Entity\UnitOfMeasurement;
                        $weightUnit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_LBS);
                        $package->getPackageWeight()->setUnitOfMeasurement($weightUnit);

                        $dimensions = new \Ups\Entity\Dimensions();
                        $dimensions->setHeight($item->options['height']);
                        $dimensions->setWidth($item->options['width']);
                        $dimensions->setLength($item->options['length']);

                        $unit = new \Ups\Entity\UnitOfMeasurement;
                        $unit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_IN);

                        $dimensions->setUnitOfMeasurement($unit);
                        $package->setDimensions($dimensions);
                        $shipment->addPackage($package);
                    }
                }
            }
            $shopRates = $rate->getRate($shipment);

            foreach ($shopRates as $row) {
                foreach ($row as $RatedShipment) {
                    $data[] = [
                        'shipping_service' => $RatedShipment->Service->getName(),
                        'shipping_code' => $RatedShipment->Service->getCode(),
                        'amount' => $RatedShipment->TotalCharges->MonetaryValue
                    ];
                }
            }

            return $data;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function get_fedex_rating()
    {
        $postalCode = Session::get('postalCodeSession');
        $totalWeight = $this->get_total_weight();

        // try {
            $rateRequest = new RateRequest();

            //authentication & client details
            $rateRequest->WebAuthenticationDetail->UserCredential->Key = 'J4gf5oINJB0DOXTZ';
            $rateRequest->WebAuthenticationDetail->UserCredential->Password = 'MYMU8DFopfS1v20jj1x5K6q8q';
            $rateRequest->ClientDetail->AccountNumber = 510087860;
            $rateRequest->ClientDetail->MeterNumber = 119191349;

            $rateRequest->TransactionDetail->CustomerTransactionId = 'testing rate service request';

            //version
            $rateRequest->Version->ServiceId = 'crs';
            $rateRequest->Version->Major = 28;
            $rateRequest->Version->Minor = 0;
            $rateRequest->Version->Intermediate = 0;

            $rateRequest->ReturnTransitAndCommit = true;

            //shipper
            $rateRequest->RequestedShipment->PreferredCurrency = 'USD';
            $rateRequest->RequestedShipment->Shipper->Address->StreetLines = ['1488 E Iron Eagle Dr.'];
            $rateRequest->RequestedShipment->Shipper->Address->City = 'Eagle';
            $rateRequest->RequestedShipment->Shipper->Address->StateOrProvinceCode = 'ID';
            $rateRequest->RequestedShipment->Shipper->Address->PostalCode = 83634;
            $rateRequest->RequestedShipment->Shipper->Address->CountryCode = 'US';


            // $rateRequest->RequestedShipment->PreferredCurrency = 'USD';
            // $rateRequest->RequestedShipment->Shipper->Address->StreetLines = ['10 Fed Ex Pkwy'];
            // $rateRequest->RequestedShipment->Shipper->Address->City = 'Memphis';
            // $rateRequest->RequestedShipment->Shipper->Address->StateOrProvinceCode = 'TN';
            // $rateRequest->RequestedShipment->Shipper->Address->PostalCode = 38115;
            // $rateRequest->RequestedShipment->Shipper->Address->CountryCode = 'US';

            //recipient
            // $rateRequest->RequestedShipment->Recipient->Address->StreetLines = ['13450 Farmcrest Ct'];
            // $rateRequest->RequestedShipment->Recipient->Address->City = 'Herndon';
            // $rateRequest->RequestedShipment->Recipient->Address->StateOrProvinceCode = 'VA'; 
            $rateRequest->RequestedShipment->Recipient->Address->PostalCode = $postalCode;
            $rateRequest->RequestedShipment->Recipient->Address->CountryCode = 'US';

            //shipping charges payment
            $rateRequest->RequestedShipment->ShippingChargesPayment->PaymentType = PaymentType::_SENDER;

            //rate request types
            // $rateRequest->RequestedShipment->RateRequestTypes = [RateRequestType::_PREFERRED, RateRequestType::_LIST];
            $rateRequest->RequestedShipment->RateRequestTypes = [RateRequestType::_PREFERRED];

            $rateRequest->RequestedShipment->PackageCount = 1;

            //create package line items
            $rateRequest->RequestedShipment->RequestedPackageLineItems = [new RequestedPackageLineItem()];

            //package 1
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Value = $totalWeight;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Units = WeightUnits::_LB;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Length = 10;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Width = 10;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Height = 3;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Units = LinearUnits::_IN;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->GroupPackageCount = 1;

            // //package 2
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Value = 5;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Units = WeightUnits::_LB;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Length = 20;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Width = 20;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Height = 10;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Units = LinearUnits::_IN;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->GroupPackageCount = 1;

            $rateServiceRequest = new FedExREquest();
            //$rateServiceRequest->getSoapClient()->__setLocation(Request::PRODUCTION_URL); //use production URL

            $rateReply = $rateServiceRequest->getGetRatesReply($rateRequest); // send true as the 2nd argument to return the SoapClient's stdClass response.
            // dd($rateReply);

            if (!empty($rateReply->RateReplyDetails)) {
                foreach ($rateReply->RateReplyDetails as $rateReplyDetail) {
                    // var_dump($rateReplyDetail->ServiceType);
                    if (!empty($rateReplyDetail->RatedShipmentDetails)) {
                        foreach ($rateReplyDetail->RatedShipmentDetails as $ratedShipmentDetail) {
                            // var_dump($ratedShipmentDetail->ShipmentRateDetail->RateType . ": " . $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Amount);
                            $data[] = [
                                'shipping_service' => $rateReplyDetail->ServiceType,
                                'shipping_code' => $rateReplyDetail->ServiceType,
                                'amount' => $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Amount
                            ];
                        }
                    }
                    // echo "<hr />";
                }
                // dump($data);
                return $data;
            }else{
                // foreach ($rateReply->Notifications as $Notification) {
                //     // return $Notification->Message;
                //     // dump( $Notification->Message);
                //     return redirect()->back()->with('error', $Notification->Message);
                // }
                return redirect()->back()->with('error', 'FedEx service not available.');
            }

            // dump($rateReply->RateReplyDetails); 
            // dump($data);

            // dd($rateReply);
            // return $data;
        // } catch (\Exception $e) {
        //     return redirect()->back()->with('error', $e->getMessage());
        // }
    }

    public function get_autherize_net()
    {
        // $grandTotal = Session::get('grandTotalSesssion');
        // return view('site.order.paypal', compact('grandTotal'));

        // $grandTotal = Session::get('grandTotalSesssion');
        // return view('site.payment.authorize_net', compact('grandTotal'));
    }

    public function post_authorize_net(Request $request)
    {
        // code...
    }

    public function post_authorize_net_status(Request $request)
    {
        // code...
    }

}