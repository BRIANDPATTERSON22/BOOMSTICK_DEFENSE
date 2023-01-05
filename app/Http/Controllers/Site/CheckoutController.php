<?php namespace App\Http\Controllers\Site;

use App\Country;
use App\Coupon;
use App\Customer;
use App\CustomerPaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Site\CheckoutAddresRequest;
use App\Http\Requests\Site\CheckoutRequest;
use App\Http\Requests\Site\CustomerRequest;
use App\Option;
use App\Order;
use App\OrderItem;
use App\Payment;
use App\Product;
use App\Shipping;
use Carbon\Carbon;
use DB;
use DateTime;
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
use Validator;

use FedEx\CloseService\SimpleType\LinearUnits;
use FedEx\CourierDispatchService\SimpleType\WeightUnits;
use FedEx\InFlightShipmentService\SimpleType\PaymentType;
use FedEx\OpenShipService\ComplexType\RequestedPackageLineItem;
use FedEx\OpenShipService\SimpleType\RateRequestType;
use FedEx\RateService\ComplexType\RateRequest;
use FedEx\RateService\Request as FedExREquest;
// use FedEx\RateService\ComplexType;
// use FedEx\RateService\SimpleType;

class CheckoutController extends Controller
{
    private $_api_context;

    public function __construct(
        Country $country,
        Customer $customer,
        Product $product,
        Order $order,
        OrderItem $orderItem,
        Shipping $shipping,
        Payment $payment,
        Coupon $coupon,
        CustomerPaymentMethod $customerPaymentMethod)
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
        // $this->middleware('auth');

        $this->option = Cache::get('optionCache');
        $this->loggedInCustomer = $this->customer->where('user_id', Auth::id())->first();
    }

    public function post_address(CustomerRequest $request)
    {
        $address = $request->is_same_as_billing == 1 ? $request->address1 : $request->address2;
        $city = $request->is_same_as_billing == 1 ? $request->city : $request->delivery_city;
        $state = $request->is_same_as_billing == 1 ? $request->state : $request->delivery_state;
        $postalCode = $request->is_same_as_billing == 1 ? $request->postal_code : $request->delivery_postel_code;
        $countryId = $request->is_same_as_billing == 1 ? $request->billing_country_id : $request->delivery_country_id;

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

            Session::put('postalCodeSession', $request->is_same_as_billing == 1 ? $request->postal_code : $request->delivery_postel_code);
            Session::put('addressValidationSession', $request->all());
            Session::put('isSameAsBillingSession', $request->is_same_as_billing);

            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Session::forget('addressValidationSession');
            Session::forget('shippingSingleDataSession');
            return redirect('checkout')->with('error', $e->getMessage())->withInput();
        }

        // Session::put('postalCodeSession', $request->is_same_as_billing == 1 ? $request->postal_code : $request->delivery_postel_code);
        // Session::put('addressValidationSession', $request->all());
        // Session::put('isSameAsBillingSession', $request->is_same_as_billing);

        // if($request->is_same_as_billing == 1){
        //     $deliveryAddress = [
        //         'address2' => $request->address1,
        //         'delivery_city' => $request->city,
        //         'delivery_state' => $request->state,
        //         'delivery_postel_code' => $request->postal_code,
        //         'delivery_country_id' => $request->billing_country_id,
        //         'is_same_as_billing' => 1,
        //     ];
        // }else{
        //     $deliveryAddress = [
        //         'address2' => $request->address2,
        //         'delivery_city' => $request->delivery_city,
        //         'delivery_state' => $request->delivery_state,
        //         'delivery_postel_code' => $request->delivery_postel_code,
        //         'delivery_country_id' => $request->delivery_country_id,
        //         'is_same_as_billing' => 0,
        //     ];
        // }

        // Session::put('deliveryAddressSession', $deliveryAddress);
        // return redirect()->back()->withInput();
    }

    public function post_shipping(Request $request)
    {
        $validator = Validator::make($request->all(), [
                   // 'ship_method' => 'required',
               ]);
        if ($validator->fails()) {
                  return redirect()
                        ->back()
                      ->withErrors($validator)
                      ->withInput();
              }

        // $shipingId = $request->ship_method;
        // $shippingData = $this->shipping->find($shipingId);
        // Session::put('shipping', $shippingData);
        // Session::put('shipping_amount', $shippingData->amount);
        // Session::put('shippingIdSession', $shipingId);
        
        // return redirect()->back()->with('success', 'The shipping method has been updated ');

        $mainShippingId = $request->main_shipping_method;
        $subShippingId = $request->sub_shipping_method;
        $subShippingAmount = $request->sub_shipping_method_price;
        $subShippingServiceName = $request->sub_shipping_method_service_name;
        $singleShippingData = $this->shipping->find($mainShippingId);

        Session::put('shippingSingleDataSession', $singleShippingData);
        Session::put('mainShippingIdSession', $mainShippingId);
        Session::put('mainShippingAmountSession', $singleShippingData->amount);
        // Session::put('fallbackShippingAmountSession', $singleShippingData->amount);
        Session::put('subShippingIdSession', $subShippingId);
        Session::put('subShippingAmountSession', $subShippingAmount);
        Session::put('subShippingServiceNamesSession', $subShippingServiceName);

        return redirect()->back();
    }

    public function post_payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
                   'payment_method' => 'required',
               ]);
        if ($validator->fails()) {
                  return redirect()
                        ->back()
                      ->withErrors($validator)
                      ->withInput();
              }

        $paymentId = $request->payment_method;

        $paymentData = $this->payment->find($paymentId);
        Session::put('paymentSingleDataSession', $paymentData);
        Session::put('paymentIdSession', $paymentId);
        
        // return redirect()->back()->with('success', 'The payment method has been updated');
        return redirect()->back();
    }

    public function get_checkout()
    {
        // if (Cart::instance('cart')->count() == 0) {
        //     return redirect('products')->with('success', 'Your cart is empty, Add some products.');
        // }

        $countries = $this->country->pluck('nicename', 'id');
        $otherProducts = $this->product->limit(5)->get();
        $cartItems = Cart::instance('cart')->content();
        $customer = $this->customer->where('user_id', Auth::id())->first();

        // Available shipping Data
        $shippingData = $this->shipping->where('status', 1)->get();
        $shippingAmount = Session::get('subShippingAmountSession') ?? Session::get('mainShippingAmountSession');

        // Available Payment Data
        $allPaymentsData = $this->payment->where('status', 1)->get();
        $paymentSingleData = Session::get('paymentSingleDataSession');

        // UPS Shipping method
        if(session('addressValidationSession') && is_array($this->get_rating()) ){
            $rating = $this->get_rating();
        }else{
            $rating = [];
        }

        // FedEx Shipping method
        if(session('addressValidationSession') && is_array($this->get_fedex_rating()) ){
            $fedExRating = $this->get_fedex_rating();
        }else{
            $fedExRating = [];
        }

        return view('site.order.checkout', compact('countries', 'cartItems', 'customer', 'shippingData', 'shippingAmount', 'allPaymentsData', 'paymentSingleData', 'rating', 'fedExRating'));
    }

    function order_number()
    {
        $latest = Order::latest()->withTrashed()->first();
        // $latest = Order::latest()->first();
        if (! $latest) {
            return 'ORDZO0205000';
        }
        $string = preg_replace("/[^0-9\.]/", '', $latest->order_no);
        return 'ORDZO0' . sprintf('%04d', $string+1);
    }


    public function post_checkout(CheckoutRequest $request)
    {
        if (Cart::instance('cart')->count() == 0) {
            return redirect('cart')->with('Your cart is empty.');
        }
        
        if (!session()->has('shippingSingleDataSession')) {
            return redirect()->back()->with('error', 'Please, select your shipping method.')->withInput();
        }

        if (!session()->has('paymentSingleDataSession')) {
            return redirect()->back()->with('error', 'Please, select your payment method.')->withInput();
        }

        $customerData = Session::get('addressValidationSession');
        $isSameAsBilling = Session::get('isSameAsBillingSession');
        $mainShippingId = Session::get('mainShippingIdSession');
        $subShippingId = Session::get('subShippingIdSession');
        $shippingAmount = Session::get('subShippingAmountSession') ?? Session::get('mainShippingAmountSession');
        $shippingServiceName = Session::get('subShippingServiceNamesSession');
        $paymentId = Session::get('paymentIdSession');


        // dd(session()->has('shipping'));
        
        // $isUserRegistered = $this->user->where('email', $request->email)->first();
        // if ($isUserRegistered) {
        //     # code...
        // }
        // //Create user
        // $this->user->role_id = 2;
        // $this->user->name = $request->first_name.' '.$request->last_name;
        // $this->user->email = strtolower($request->email);
        // $this->user->password = Hash::make(str_random(10));
        // $this->user->status = 1;
        // $this->user->ip  = $request->getClientIp(); // Registered IP Address
        // $this->user->save();
        // $userId = $this->user->id; //Get last save id

        // //Assign role
        // DB::table('model_has_roles')->insert(['role_id' => '2','model_id' =>  $userId, 'model_type'=>'App\User']);


        // Save Customer Info
        // $this->customer->fill($request->all());
        $this->customer->fill($customerData);
        $this->customer->role_id = 2;
        $this->customer->status = 1;
        // $this->customer->is_same_as_billing = 1;
        // if($request->is_same_as_billing == 1){
        //     $this->customer->address2 = $request->address1;
        //     $this->customer->delivery_city = $request->city;
        //     $this->customer->delivery_state = $request->state;
        //     $this->customer->delivery_postel_code = $request->postal_code;
        //     $this->customer->delivery_country_id = $request->billing_country_id;
        // }

        if($isSameAsBilling == 1){
            $this->customer->address2 = $customerData['address1'];
            $this->customer->delivery_city = $customerData['city'];
            $this->customer->delivery_state = $customerData['state'];
            $this->customer->delivery_postel_code = $customerData['postal_code'];
            $this->customer->delivery_country_id = $customerData['billing_country_id'];
        }

        $this->customer->save();
        $customerId = $this->customer->id;

        // Create Order
        $order_no = $this->order_number();
        $this->order->order_no = $order_no;
        $this->order->customer_id = $customerId;
        $this->order->note = $request->note;
        $this->order->timezone_identifier = $request->timezone_identifier;
        $this->order->status = 1; //1.Approval pending 2. Order Approved 3. Order Rejected 4. Dispatched 5.Delivered
        $this->order->checkout_type = 1; //1.Guest 2. Customer 3. Wholesale
        if (session('paymentIdSession') == 4) {
            $this->order->pay_status = "INCOMPLETED"; // 1-UNPAID 2- PAID 3-INCOMPLETED 4-FAILED 5-ERROR
        }else{
            $this->order->pay_status = "UNPAID";
        }
        $this->order->save();
        $orderId = $this->order->id;

        // Cart Data
        $cartItems = Cart::instance('cart')->content();
        $orderItems = null;
        
        foreach ($cartItems as $item) {
            $orderItems[] = [
                'order_id' => $orderId,
                'product_id' => $item->id,
                'quantity' => $item->qty,
                'product_discount' => $item->discount_percentage,
                'customer_discount' => $item->qty,
                'price' => $item->price,
                'store_id' => $item->options['store_id'],
                'status' => 1,
                'created_at' =>  new DateTime,
                'updated_at' =>  new DateTime,
                // 'is_product_discount' => $item->options['product_discount'] ? 1 : 0,
            ];

            $arrTotalPrice[] = $item->qty * $item->price;
        }

        if ($orderItems){
            $this->orderItem->insert($orderItems);
        }

        $totalPrice =  array_sum($arrTotalPrice);
        // $grandTotal = $totalPrice + Session::get('shipping_amount');
        $grandTotal = $totalPrice + $shippingAmount;

        // Save SubTotal
        $this->order = $this->order->find($orderId);
        // $this->order->shipping = Session::get('shipping_amount');
        // $this->order->shipping_id = Session::get('shippingIdSession');
        // $this->order->payment_id = Session::get('paymentIdSession');
        $this->order->shipping = $shippingAmount;
        $this->order->shipping_id = $mainShippingId;
        $this->order->shipping_service_id = $subShippingId;
        $this->order->shipping_service_name = $shippingServiceName;
        $this->order->payment_id = $paymentId;

        $this->order->amount = $totalPrice;
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
            'email_1' => $option->email_1,
            'email_2' => $option->email_2,
            'email_3' => $option->email_3,
            'siteName' => $option->name,
        ];

        // Add session
        Session::put('order', $order);
        Session::put('orderItems', $orderItems);
        Session::put('mailData', $data);

        //Clear all session
        // Cart::instance('cart')->destroy();
        // Session::forget('shipping_amount');

        // Email to admin
        // Mail::send('emails.order.request', compact('order', 'orderItems'), function ($message) use ($data) {
        //     $message->to($data['siteEmail'])->subject('Order Received - ' . $data['siteName']);
        // });

        // Email to User
        // Mail::send('emails.order.confirmation', compact('order', 'orderItems'), function ($message) use ($data) {
        //     $message->to($data['email'])->subject('Order Confirmation - ' . $data['siteName']);
        // });

        // Reduce Quantity
        foreach ($orderItems as $row){
            $this->product = $this->product->find($row->product_id);
            $this->product->quantity = $this->product->quantity - $row->quantity;
            $this->product->save();
        }

        if (session('paymentSingleDataSession')['id'] == 1) {  //Pay on Delivery
            return $this->sendMail();
        }elseif (session('paymentSingleDataSession')['id'] == 2) {  // Paypal
            return view('site.order.paypal', compact('grandTotal'));
        }else{
           return $this->sendMail();
        }

        // return redirect('order-completed')->with('success', 'Your order has been placed and you will receive an order confirmation email. Thank you.');
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
        
        Mail::send('emails.order.request', compact('order', 'orderItems'), function ($message) use ($data) {
            $message->to($data['email_1'])->subject('Order Received - ' . $data['siteName']);
        });
        
        Mail::send('emails.order.request', compact('order', 'orderItems'), function ($message) use ($data) {
            $message->to($data['email_2'])->subject('Order Received - ' . $data['siteName']);
        });
        
        Mail::send('emails.order.request', compact('order', 'orderItems'), function ($message) use ($data) {
            $message->to($data['email_3'])->subject('Order Received - ' . $data['siteName']);
        });

        // Clear Cart from session
        // Cart::instance('cart')->destroy();
        // Session()->flush();

        return redirect('order-completed')->with('success', 'Your order has been placed and you will receive an order confirmation email. Thank you.');
    }

    public function post_paypal_status(Request $request)
    {
        $this->order
            ->where('id', Session('order')['id'])
            ->update([
                'status' => 1, 
                'pay_status' => 'PAID', 
                'paypal_payment_id' =>  $request->orderId, 
                'paypal_payer_id' => $request->payerID
            ]);

        $this->sendMail();
        
        return response()->json(['data' => true], 200);
    }

    public function payment()
    {
        return view('site.order.paypal');
    }

    public function get_order_completed()
    {
        $orderNo = session('order')['order_no'];
        Session::forget('order');
        Cart::instance('cart')->destroy();
        Session()->flush();

        if($orderNo){
            return view('site.order.completed', compact('orderNo'));
        }
        
        return view('site.errors.404');
    }

    // 
    public function get_order_cancelled()
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

    public function get_ups_rating()
    {
        $postalCode = Session::get('postalCodeSession');
        // $postalCode = 20001;
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

            // dump($rate->getRate($shipment));
            $shopRates = $rate->getRate($shipment);
            // $shopRates = $rate->shopRates($shipment);

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
            // $rateRequest->RequestedShipment->RequestedPackageLineItems = [new RequestedPackageLineItem()];

            for ($i=0; $i < Cart::content()->count(); $i++) { 
                $packageObjects[] = new RequestedPackageLineItem();
            }
            $rateRequest->RequestedShipment->RequestedPackageLineItems = $packageObjects;

            dump($rateRequest->RequestedShipment->RequestedPackageLineItems);

            // // //package 1

            // for ($i=0; $i < Cart::content()->count(); $i++) { 
                foreach (Cart::instance('cart')->content() as $item) {
                    // $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Weight->Value = 18;
                    // $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Weight->Units = WeightUnits::_LB;
                    // $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Dimensions->Length = 4.2;
                    // $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Dimensions->Width = 2.3;
                    // $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Dimensions->Height = 2.3;
                    // $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Dimensions->Units = LinearUnits::_IN;
                    // $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->GroupPackageCount = 3;

                    $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Weight->Value = $item->options['weight'];
                    $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Weight->Units = WeightUnits::_LB;
                    $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Dimensions->Length = $item->options['length'];
                    $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Dimensions->Width = $item->options['width'];
                    $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Dimensions->Height = $item->options['height'];
                    $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Dimensions->Units = LinearUnits::_IN;
                    $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->GroupPackageCount = $item->qty;
                }
            // }

              dump($rateRequest->RequestedShipment->RequestedPackageLineItems);

            // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Value = 18;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Units = WeightUnits::_LB;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Length = 4.2;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Width = 2.3;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Height = 2.3;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Units = LinearUnits::_IN;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->GroupPackageCount = 3;

            // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Units = WeightUnits::_LB;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Value = 1;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Length = 1;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Width = 1;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Height = 1;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Units = LinearUnits::_IN;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->GroupPackageCount = 1;

            // $cartItems = Cart::instance('cart')->content();
            // if ($cartItems->count() > 0) {
            //     foreach ($cartItems as $item) {
            //         // dump( $item);
            //         // for ($i=0; $i <= $item->qty; $i++) { 
            //             //package 1
            //             $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Value = $item->options['weight'];
            //             $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Units = WeightUnits::_LB;
            //             $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Length = $item->options['length'];
            //             $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Width = $item->options['width'];
            //             $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Height = $item->options['height'];
            //             $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Units = LinearUnits::_IN;
            //             $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->GroupPackageCount = $item->qty;

            //             // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Value = $item->options['weight'];
            //             // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Units = WeightUnits::_LB;
            //             // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Length = $item->options['length'];
            //             // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Width = $item->options['width'];
            //             // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Height = $item->options['height'];
            //             // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Units = LinearUnits::_IN;
            //             // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->GroupPackageCount =1;
            //         // }
            //     }
            // }

            // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Value = $item->options['weight'];
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Units = WeightUnits::_LB;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Length = $item->options['length'];
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Width = $item->options['width'];
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Height = $item->options['height'];
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Units = LinearUnits::_IN;
            // $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->GroupPackageCount =1;

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
                foreach ($rateReply->Notifications as $Notification) {
                    // return $Notification->Message;
                    // dump( $Notification->Message);
                    return redirect()->back()->with('error', $Notification->Message);
                }
            }

            // dump($rateReply->RateReplyDetails); 
            // dump($data);

            // dd($rateReply);
            // return $data;
        // } catch (\Exception $e) {
            // return redirect()->back()->with('error', $e->getMessage());
        // }
    }
}