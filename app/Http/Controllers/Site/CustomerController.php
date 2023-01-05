<?php namespace App\Http\Controllers\Site;

use App\WishList;
use Hash;
use App\Order;
use App\User;
use App\Customer;
use App\TradeCustomer;
use App\RetailCustomer;
use App\CakeTimeClub;
use App\Country;
use App\Http\Requests\Site\PasswordRequest;
use App\Http\Requests\Site\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

use SagePay;

class CustomerController extends Controller
{
    public function __construct(
        Customer $customer,
        User $user,
        Country $country,
        Order $order,
        WishList $wishList,
        RetailCustomer $retailCustomer,
        CakeTimeClub $cakeTimeClub,
        TradeCustomer $tradeCustomer
    )
    {
        $this->customer = $customer;
        $this->retailCustomer = $retailCustomer;
        $this->cakeTimeClub = $cakeTimeClub;
        $this->tradeCustomer = $tradeCustomer;
        $this->user = $user;
        $this->country = $country;
        $this->order = $order;
        $this->wishList = $wishList;
        $this->module = "customer";

        $this->option = Cache::get('optionCache');
        $this->middleware('auth');
    }

    public function get_my_account()
    {
        $user= Auth::user();

        $customer = $this->customer->where('user_id', Auth::id())->first();
        $orders_c = $this->order->where('customer_id', $customer->id)->count();
        $countries = $this->country->orderBy('name', 'ASC')->pluck('nicename', 'id');
        $wishListsCount = $this->wishList->where('customer_id', $customer->id)->count();
        
        return view('site.customer.account',compact('customer', 'countries', 'orders_c','wishListsCount'));
    }

    public function post_my_account(ProfileRequest $request)
    {
        $module = $this->module;
        $user_id = Auth::id();

        $this->customer = $this->customer->where('user_id', $user_id)->first();
        $this->customer->fill($request->all());
        $oldFilename = $filename = $this->customer->image;
        //Image upload function
        if($request->image) {
            $file = $request->image;
            Image::make($file)->widen(512)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = $module.'s/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete($module.'s/'.$oldFilename);
        }

        $this->customer->image = $filename;
        $request->is_same_as_billing == 1 ? $this->customer->is_same_as_billing = 1 : $this->customer->is_same_as_billing = 0;

        if($request->is_same_as_billing == 1){
            $this->customer->address2 = $request->address1;
            $this->customer->delivery_city = $request->city;
            $this->customer->delivery_state = $request->state;
            $this->customer->delivery_postel_code = $request->postal_code;
            $this->customer->delivery_country_id = $request->billing_country_id;
        }
        $this->customer->save();

        $this->user = $this->user->find($user_id);
        $this->user->name = $request->first_name.' '.$request->last_name;
        $this->user->save();

        return redirect('my-account')->with('success', 'Your account details have been updated.');
    }


    public function post_my_image(Request $request)
    {
        $module = $this->module;
        $user_id = Auth::id();

        $this->customer = $this->customer->where('user_id', $user_id)->first();
        // $this->customer->fill($request->all());
        $oldFilename = $filename = $this->customer->image;
        //Image upload function
        if($request->image) {
            $file = $request->image;
            // Image::make($file)->widen(210)->save($file);
            Image::make($file)->widen(210, function ($constraint) {$constraint->upsize(); })->crop(210,210)->fill('#ffffff', 0, 0)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = $module.'s/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete($module.'s/'.$oldFilename);
        }

        $this->customer->image = $filename;
        $this->customer->save();

        return redirect('my-account')->with('success', 'Your image has been successfully uploaded');
    }
    public function profile_image_delete($id)
    {
        $module = $this->module;

        $data = $this->customer->find($id);
        if($data) {
            Storage::delete($module.'s/'.$data->image);
            $data->update(['image'=>null]);
            return redirect()->back()->with('success', 'The image has been successfully deleted.');
        }
        else {
            return redirect()->back()->with('error', 'The image has not been deleted.');
        }
    }


    public function image_delete($id)
    {
        $data = $this->user->find($id);
        if($data) {
            $path = public_path().'/images/users/'.$id.'/';
            File::Delete($path);
            $data->update(['image'=>'']);
            return redirect()->back()->with('success', 'Profile image has been deleted successfully.');
        }else {
            return redirect()->back()->with('error', 'Profile image has not been deleted.');
        }
    }

    public function get_change_password()
    {
        $user_id = Auth::id();
        $user = $this->user->find($user_id);

        $customer = $this->customer->where('user_id', $user_id)->first();
        $orders_c = $this->order->where('customer_id', $customer->id)->count();
        $wishListsCount = $this->wishList->where('customer_id', $customer->id)->count();

        return view('site.customer.password', compact('user','customer', 'orders_c','wishListsCount'));
    }

    public function post_change_password(PasswordRequest $request)
    {
        $user_id = Auth::id();
        $this->user = $this->user->find($user_id);

        $credentials = [
            'email' => $request->email,
            'password' => $request->old_password,
        ];

        if (Auth::attempt($credentials)) {
            $this->user->fill($request->all());
            $this->user->password = Hash::make($request->password);
            $this->user->save();
            Auth::login($this->user);

            return redirect('change-password')->with('success', 'Your password has been successfully changed.');
        }
        else{
            return redirect()->back()->with('error', 'You have entered an invalid email or password. Please try again.');
        }
    }

    public function get_my_orders()
    {
        $customer = $this->customer->where('user_id', Auth::id())->first();

        $orders = $this->order->where('customer_id', $customer->id)->orderBy('created_at', 'DESC')->paginate(5);

        $orders_c = $this->order->where('customer_id', $customer->id)->count();
        $wishListsCount = $this->wishList->where('customer_id', $customer->id)->count();

        return view('site.customer.order', compact('orders', 'customer', 'orders_c','wishListsCount'));
    }

    public function get_my_wishlist()
    {
        $customer = $this->customer->where('user_id', Auth::id())->first();
        $orders_c = $this->order->where('customer_id', $customer->id)->count();
        $wishListsCount = $this->wishList->where('customer_id', $customer->id)->count();
        $wishListsData = $this->wishList->where('customer_id', $customer->id)->orderBy('created_at', 'DESC')->paginate(8);

        return view('site.customer.wishlist', compact('wishListsCount','wishListsData', 'customer', 'orders_c'));
    }

    public function get_subscription_payment()
    {
        $userId = \Session::get('user')->id;
        $customerData = $this->customer->where('user_id', $userId)->first();

        if($customerData->membership_type == 1){
            SagePay::setAmount($this->option->six_month_subscription_amount);
        }
        if($customerData->membership_type == 2){
            SagePay::setAmount($this->option->twelve_month_subscription_amount);
        }
        // SagePay::setAmount('100');
        if($customerData->membership_type == 1){
            SagePay::setDescription('6 Month Subscription Amount');
        }
        if($customerData->membership_type == 2){
            SagePay::setDescription('1 Year Subscription Amount');
        }
        // SagePay::setDescription('Lorem ipsum');
        SagePay::setBillingSurname($customerData->last_name);
        SagePay::setBillingFirstnames($customerData->first_name);
        SagePay::setBillingCity($customerData->city);
        SagePay::setBillingPostCode($customerData->postal_code);
        SagePay::setBillingAddress1($customerData->address1);
        // SagePay::setBillingCountry($customerData->billingCountry->iso);
        SagePay::setBillingCountry($customerData->billingCountry->iso);
        SagePay::setDeliverySameAsBilling();
        SagePay::setSuccessURL(url('cake-time-club-payment-status'));
        SagePay::setFailureURL(url('cake-time-club-payment-status'));

        // SagePay::setSuccessURL('https://localhost/sagepay.dev/payment/' . $billing_token);
        // SagePay::setFailureURL('https://localhost/sagepay.dev/payment/' . $billing_token);

        $encrypted_code = SagePay::getCrypt();

        return view('site.auth.subscription_payment',compact('customerData', 'encrypted_code'));
    }

    public function get_subscription_payment_status(Request $request)
    {
        $userId = Auth::id();
        $customerData = $this->customer->where('user_id', $userId)->first();

        if ($request->has('crypt')) {
            $responseArray = SagePay::decode($request->get('crypt'));
            if($responseArray["Status"] === "OK"){
                $customerData->update(['is_paid' => 1, 'payment_id' => 5]);
                return redirect('cake-time-club-payment-completed')->with('success', 'Payment Success!');
            }
            elseif($responseArray["Status"] === "ABORT"){
                $customerData->update(['is_paid' => 3, 'payment_id' => 5]);
                return view('site.auth.subscription_cancelled');
            }
            else{
                return redirect()->back()->with('error', 'Sagepay payment failed!!');
            }
        }elseif($request->has('token')){
            $customerData->update(['is_paid' => 1, 'payment_id' => 2]);
            return redirect('cake-time-club-payment-completed')->with('success', 'Payment Success!');
        }else{
            //there was no crypt url parameter
            // $customerData->update(['is_paid' => 0]);
            return redirect()->back()->with('error', 'Sagepay payment failed!');
        }
    }

    public function get_payment_completed()
    {
        return view('site.auth.subscription_completed');
    }

    public function get_payment_cancelled()
    {
        // $userId = Auth::id();
        // $customerData = $this->customer->where('user_id', $userId)->first();
        // $customerData->update(['is_paid' => 0, 'payment_id' => 2]);
        return view('site.auth.subscription_cancelled');
    }





    // #1. Merchant Session Keys
    public function get_merchant_session_keys()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://pi-test.sagepay.com/api/v1/merchant-session-keys",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => '{ "vendorName": "guypaulcompany" }',
          CURLOPT_HTTPHEADER => array(
            "Authorization: Basic MEhIbll1UlRpVTZsSlppWFVPcVg1cXNpNTRJbXB2RWZwNkdhd0I5c1lnRlRTaG9VZTM6V3NnM2pvQW9NdnZIWldwOFNadFlzbWttMWU0eUFkZmlxYlB1T1VVdnpBdkE5YU9rdGpNRldNYU5MY1E3QjVkRTk=",
            "Cache-Control: no-cache",
            "Content-Type: application/json"
          ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $response = json_decode($response, true);
        session()->put('ms', $response['merchantSessionKey']);
        // dd($response);
        curl_close($curl);
        return $this->card_identifier();
    }

    // #2. Card Identifiers
    public function card_identifier()
    {
        $merchantSessionKey = session()->get('ms');
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://pi-test.sagepay.com/api/v1/card-identifiers",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => '{' .
                                    '"cardDetails": {' .
                                    '    "cardholderName": "SAM JONES",' .
                                    '    "cardNumber": "4929000000006",' .
                                    '    "expiryDate": "0320",' .
                                    '    "securityCode": "123"' .
                                    '}' .
                                '}',
          CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer $merchantSessionKey",
            "Cache-Control: no-cache",
            "Content-Type: application/json"
          ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response, true);
        session()->put('ci', $response['cardIdentifier']);
        $err = curl_error($curl);
        curl_close($curl);
        // dd( $response);
        return $this->post_sagepay_payment();
    }

    // #3. The card security code, also known as CV2, CVV or CVC, this is used in CV2 checks.
    public function security_code()
    {
        $merchantSessionKey = session()->get('ms');
        $cardIdentifier = session()->get('ci');
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://pi-test.sagepay.com/api/v1/card-identifiers/$cardIdentifier/security-code",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => '{' .
                                    '"securityCode": "123"' .
                                '}',
          CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer $merchantSessionKey",
            "Cache-Control: no-cache",
            "Content-Type: application/json"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        dd($response);
        curl_close($curl);
    }

    // #4. Transactions
    public function post_sagepay_payment()
    {
        $merchantSessionKey = session()->get('ms');
        $cardIdentifier = session()->get('ci');
        $curl = curl_init();

        $postArray = [
          'transactionType' => 'Payment',
          'paymentMethod' => [
            'card' => [
              'merchantSessionKey' => $merchantSessionKey,
              'cardIdentifier' => $cardIdentifier ,
              'save' => 'false',
            ],
          ],
          'vendorTxCode' => 'cake_time_club_transaction_' . time(),
          'amount' => 50000,
          'currency' => 'GBP',
          'description' => 'Cake Time Club transaction',
          'apply3DSecure' => 'UseMSPSetting',
          'customerFirstName' => 'Sam',
          'customerLastName' => 'Jones',
          'billingAddress' => [
            'address1' => '407 St. John Street',
            'city' => 'London',
            'postalCode' => 'EC1V 4AB',
            'country' => 'GB',
          ],
          'entryMethod' => 'Ecommerce',
        ];

        $postBody = json_encode($postArray);

        curl_setopt_array($curl, array(
                CURLOPT_URL => "https://pi-test.sagepay.com/api/v1/transactions",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => $postBody,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic MEhIbll1UlRpVTZsSlppWFVPcVg1cXNpNTRJbXB2RWZwNkdhd0I5c1lnRlRTaG9VZTM6V3NnM2pvQW9NdnZIWldwOFNadFlzbWttMWU0eUFkZmlxYlB1T1VVdnpBdkE5YU9rdGpNRldNYU5MY1E3QjVkRTk=",
                    "Cache-Control: no-cache",
                    "Content-Type: application/json"
                ),
            ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);
        session()->put('transactionId', $response['transactionId']);

        $err = curl_error($curl);

        curl_close($curl);

        dd( $response );
        // If 3D Transaction Enabled
        // session()->put('paReq', $response['paReq']);
        // return redirect($response['acsUrl']);
        // return $this->threedtransactionId();
    }

    // #5. 3D Transaction 
    public function threedtransactionId()
    {
        $transactionId = session()->get('transactionId');
        $paReq = session()->get('paReq');
        
        $curl = curl_init();

        $postArray = [
          'paRes' => $paReq,
        ];

        $postBody = json_encode($postArray);

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://pi-test.sagepay.com/api/v1/transactions/$transactionId/3d-secure",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>  $postBody,
          CURLOPT_HTTPHEADER => array(
            "Authorization: Basic aEpZeHN3N0hMYmo0MGNCOHVkRVM4Q0RSRkxodUo4RzU0TzZyRHBVWHZFNmhZRHJyaWE6bzJpSFNyRnliWU1acG1XT1FNdWhzWFA1MlY0ZkJ0cHVTRHNocktEU1dzQlkxT2lONmh3ZDlLYjEyejRqNVVzNXU=",
            "Cache-Control: no-cache",
            "Content-Type: application/json"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        dd( $response);
    }


    public function post_cake_time_club_sagepay_payment()
    {
        dd(request()->all());
    }
}