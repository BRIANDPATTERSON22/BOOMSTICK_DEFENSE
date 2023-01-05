<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RsrApiController extends Controller
{
    public function __construct()
    {
        $this->liveCredentials = ['Username' => '8095', 'Password' => 'Web_Dev_2021', 'POS' => 'I'];
        $this->testCredentials = ['Username' => '8095', 'Password' => 'test8095', 'POS' => 'I'];
    }

    public function get_ffl_dealers()
    {
        try {
            $cURLConnection = curl_init('https://www.rsrgroup.com/api/rsrbridge/1.0/pos/get-transfer-dealers');
            curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $this->liveCredentials);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

            $apiResponse = curl_exec($cURLConnection);
            curl_close($cURLConnection);

            $jsonArrayResponse = json_decode($apiResponse);
            
            $availableDealers = collect($jsonArrayResponse->Dealers)
                ->where('State', strtoupper(session('stateSession')));
                // ->where('Zip', session('postalCodeSession'));

            // $availableDealersArray = [];
            // foreach ($availableDealers as $value) {
            //     $availableDealersArray[] = [
            //         'ffl_licence' => $value->FFL,
            //         'dealer_data' => "Name: " . $value->Name . ", Street: " . $value->Street . ", City: " . $value->City . ", State: " . $value->State . ", Zip: " . $value->Zip,
            //     ];
            // }

            return $availableDealers;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
            // $path = storage_path() . "/app/public/rsr-api/ffl-response-live.json";
            // $json = json_decode(file_get_contents($path), true); 
            // $response = collect($json['Dealers'])->where('State', 'NY');
            // dd($response);
        }
    }

    public function get_ffl_dealers_json()
    {
        try {
            $cURLConnection = curl_init('https://www.rsrgroup.com/api/rsrbridge/1.0/pos/get-transfer-dealers');
            curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $this->liveCredentials);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

            $apiResponse = curl_exec($cURLConnection);
            curl_close($cURLConnection);

            $jsonArrayResponse = json_decode($apiResponse);
            $availableDealers = collect($jsonArrayResponse->Dealers);

            return $availableDealers;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
