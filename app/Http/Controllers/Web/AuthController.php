<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralSettings;

class AuthController extends Controller
{
    public function requestMerchantAuthorization(Request $request)
    {
        $setting = GeneralSettings::first();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.clover.com/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'client_id='.$setting->clover_client_id.'&client_secret='.$setting->clover_client_secret.'&code=' . $request->code . '&grant_type=authorization_code',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        $result = json_decode($response);

        curl_close($curl);
        //echo $response;
        $saveVerificationCode = GeneralSettings::first();
        $saveVerificationCode->fill(['clover_bearer_token' => $result->access_token, 'clover_bearer_token_object' => json_encode($request->all())]);
        $saveVerificationCode->update();
        return response()->json(['status' => 1, 'data' => $request->all()]);
    }

    public function createInvoiceOnCloverPaymentGatewayFromGoHighLevel(Request $request)
    {
        if ($request->invoice['_data']['title'] == "from-go-high-level") {
            return response()->json(['status' => 0, 'message' => 'invalid request'], 400);
        }
        $setting = GeneralSettings::first();
        if ($setting->clover_bearer_token) {
            $curl = curl_init();

            $postData = json_encode([
                "currency" => $request->invoice['_data']['currency'],
                "employee" => [
                        "id" => $setting->clover_employee_id
                    ],
                "total" => $request->invoice['_data']['total'] * 100,
                "paymentState" => "PAID",
                "note" => "from-go-high-level",
                "taxRemoved" => false,
                "isVat" => false,
                "state" => "locked",
                "manualTransaction" => true,
                "groupLineItems" => false,
                "testMode" => false,
                "payType" => "FULL"
            ]);

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.clover.com/v3/merchants/' . $setting->clover_merchant_id . '/orders',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $postData,
                CURLOPT_HTTPHEADER => array(
                        'accept: application/json',
                        'authorization: Bearer ' . $setting->clover_bearer_token,
                        'Content-Type: application/json'
                    ),
            ));

            $response = curl_exec($curl);
            $createdOrder = json_decode($response);
            $this->addOrderPaymentInCloverPaymentGatway($createdOrder->id, $createdOrder->total, $setting->clover_merchant_id, $setting->clover_bearer_token, $setting->clover_tender_id);
            // Log the raw response from Clover for debugging
            if (curl_errno($curl)) {
                \Log::error('CURL Error:', ['error' => curl_error($curl)]);
            } else {

                // {"href": "https://www.clover.com/v3/merchants/ZSZ1TMX872D31/orders/848K13S7F4KZC", "id": "848K13S7F4KZC", "currency": "INR", "employee": {"id": "MXVWV4QFJ62YA"}, "total": 100, "note": "from-go-high-level", "taxRemoved": false, "isVat": false, "state": "locked", "manualTransaction": true, "groupLineItems": false, "testMode": false, "payType": "FULL", "createdTime": 1731325460000, "clientCreatedTime": 1731325460000, "modifiedTime": 1731325460000}
                //\Log::info('Clover API Response:', ['response' => $response]);
            }

            curl_close($curl);
        }
    }

    public function addOrderPaymentInCloverPaymentGatway($orderId, $amount, $merchantId, $bearer_token, $clover_tender_id)
    {
        if ($bearer_token) {
            $curl = curl_init();
            $postData = json_encode([
                "order" => [
                    "id" => $orderId
                ],
                "tender" => [
                    "id" => $clover_tender_id,
                    "label" => "from-go-high-level"
                ],
                "amount" => $amount,
                "tipAmount" => 0,
                "taxAmount" => 0,
                "cashbackAmount" => 0,
                "cashTendered" => 0,
                "offline" => true,
                "result" => "SUCCESS",
                "note" => "string",
                "externalReferenceId" => "string",
                "merchant" => [
                        "id" => $merchantId
                    ]
            ]);

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.clover.com/v3/merchants/' . $merchantId . '/orders/' . $orderId . "/payments",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $postData,
                CURLOPT_HTTPHEADER => array(
                        'accept: application/json',
                        'authorization: Bearer ' . $bearer_token,
                        'Content-Type: application/json'
                    ),
            ));
            $response = curl_exec($curl);
            //\Log::info($response);
            // Log the raw response from Clover for debugging
            if (curl_errno($curl)) {
                \Log::error('CURL Error:', ['error' => curl_error($curl)]);
            } else {
                //\Log::info('Clover API Response:', ['response' => $response]);
            }
            curl_close($curl);
        }
    }
}
