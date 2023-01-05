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
use Intervention\Image\Facades\Image;

class SagePayController extends Controller
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
          'vendorTxCode' => 'demotransaction' . time(),
          'amount' => 50000,
          'currency' => 'GBP',
          'description' => 'Demo transaction',
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
        // session()->put('paReq', $response['paReq']);
        $err = curl_error($curl);
        // return redirect($response['acsUrl']);
        curl_close($curl);

        dd( $response );

        return $this->threedtransactionId();
    }

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
}