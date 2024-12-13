<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoHighLevelController extends Controller
{
    public function index()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://services.leadconnectorhq.com/contacts/8Dg6HNgnU62E72iOTWxr",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false, // Disable SSL verification
            CURLOPT_SSL_VERIFYHOST => false, // Optionally disable host verification
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Authorization: Bearer pit-19702752-79d1-4ec1-8a07-695d6479655d",
                "Version: 2021-07-28",
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        // dd($err);
        $data =  json_decode($response, true);
        dd($data);

    }
}
