<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function webhookHandling(Request $request)
    {

		$input = [
			'phone' =>  $request->phone,
		];

		$rules = [
			'phone' => ['required', 'regex:/^\d{1,3}\d{4,14}(?:x.+)?$/'], // Example regex for international phone numbers
		];

		$validator = Validator::make($input,$rules);

		if ($validator->fails())
		{
			$errors = $validator->errors();
			\Log::info("Phone No - ".$request->phone." - ".print_r($errors->first('phone'), true));
		}
		else
		{
			$businessPhoneNumberId = '552882457897448';
			//$customerPhoneNumber = $request->phone;
			$customerPhoneNumber = '+919882485159';

			$token = "EAAGTGJ70GkcBO1DIDNsASrMFGeRSXTEzAltofYtjYz9FrdTZAvPMC0dib8N0Sc999bslW9BK8E6ZCvBlgJhLMORsZBIsaZBlZAXZBuZClCSlvRczcJCmcnXRZBjBjt6Q7A96XRRdPDsBRGQFgUkYJNqeZA5kITBDtBtWtzMwd67XVrlAKZCYZBEJOSGQE5nuXQDCbjkLtNj0igIPAStChq2FPNWI8GrN1Uo8OtzBEiXP8cZD";
			$flowId = '599599416056806';
			$screenId = 'RECOMMEND';

			$response = Http::withHeaders([
				'Content-Type' => 'application/json',
				'Authorization' => 'Bearer ' . $token
			])->post('https://graph.facebook.com/v21.0/' . $businessPhoneNumberId . '/messages', [
				'messaging_product' => 'whatsapp',
				'to' => $customerPhoneNumber,
				'recipient_type' => 'individual',
				'type' => 'interactive',
				'interactive' => [
					'type' => 'flow',
					'header' => [
						'type' => 'text',
						'text' => 'Thank you!'
					],
					'body' => [
						'text' => 'For using our service. Please fill our survey'
					],
					'footer' => [
						'text' => 'Have a Nice Day.'
					],
					'action' => [
						'name' => 'flow',
						'parameters' => [
							'flow_message_version' => '3',
							'flow_action' => 'navigate',
							'flow_token' => 'flows-builder-1652537s',
							'flow_id' => $flowId,
							'flow_cta' => 'Begin Survey',
							'flow_action_payload' => [
								'screen' => $screenId
							]
						]
					]
				]
			]);

			if ($response->successful()) {
				$responseData = $response->json();
				\Log::info(print_r($responseData, true));
				\Log::info(" Response Data ");

			} else {
				\Log::info(" Error Response ");
			}
		}
    }




}
