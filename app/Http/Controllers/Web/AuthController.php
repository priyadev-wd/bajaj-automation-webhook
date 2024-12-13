<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function webhookHandling(Request $request)
    {
        $token = "EAAOlTZACDiGcBO0qo6QLe520qAvZChpWXzgxIfxZCLtBLZBQLXvlPKwdOy5kLkBZBXFj4Yjh3ScBe2GdSWJ45VWP66FulWNZAiqqKcFahXJyaiMAVj3VbiYJ58UbrStoAGhueij9DDXfjOOcN2ZAokmZCiYzXCW4W67uKBvy5jBZButLIj64BayCjm4BVsyf6P2LlKZAOQ1x8rZCAFr21ZBQj1W9qOgECaijDdBzDkLHEPgZD";

        $account_id = "379233188600750";
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->get('https://graph.facebook.com/v21.0/'.$account_id, [
            'fields' => 'id,name,message_templates,phone_numbers'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            // Handle the response data
             dd($data); // dump and die to inspect the data
        } else {
            // Handle the error
             dd($response->body()); // dump and die to inspect the error
        }
    }

}
