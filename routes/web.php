<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('dashboard');  // This is the view you'd like to return
})->name('index');

// Route::get('request-merchant-authorization', 'App\Http\Controllers\Web\AuthController@requestMerchantAuthorization');
// Route::post('create-invoice-on-clover-payment-gateway-from-go-high-level', 'App\Http\Controllers\Web\AuthController@createInvoiceOnCloverPaymentGatewayFromGoHighLevel');