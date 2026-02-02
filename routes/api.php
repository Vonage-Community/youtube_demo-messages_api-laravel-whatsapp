<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Vonage\Client;
use Vonage\Client\Credentials\Keypair;
use Vonage\Messages\Channel\WhatsApp\WhatsAppText;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/message', function () {
    // create initial message
    $to = config('vonage.sandbox_customer_number');
    $from = config('vonage.sandbox_whatsapp_number');
    $text = 'Guess the magic word...';
    $message = new WhatsAppText($to, $from, $text);

    // get credentials
    $privateKeyPath = base_path(config('vonage.private_key'));
    $credentials = new Keypair(
        file_get_contents($privateKeyPath), 
        config('vonage.application_id')
    );

    // send message
    $sanboxBaseUrl = 'https://messages-sandbox.nexmo.com/v1/messages';
    $client = new Client($credentials);
    $client->messages()->getAPIResource()->setBaseUrl($sanboxBaseUrl);
    $client->messages()->send($message);
});

Route::post('/inbound', function(Request $request) {
    // create new message using info from response
    $to =  $request['from'];
    $from = config('vonage.sandbox_whatsapp_number');
    $response = $request['text'];
    if (strtolower($response) == "vonage") {
        $text = "Yes, that's it!";
    } else {
        $text = "Nope, try again.";
    };
    $message = new WhatsAppText($to, $from, $text);

     // get credentials
    $privateKeyPath = base_path(config('vonage.private_key'));
    $credentials = new Keypair(
        file_get_contents($privateKeyPath), 
        config('vonage.application_id')
    );
    
    // send message
    $sanboxBaseUrl = 'https://messages-sandbox.nexmo.com/v1/messages';
    $client = new Client($credentials);
    $client->messages()->getAPIResource()->setBaseUrl($sanboxBaseUrl);
    $client->messages()->send($message);
});

Route::post('/status', function(Request $request) {
    $message_uuid = $request['message_uuid'];
    $status = $request['status'];
    $timestamp = $request['timestamp'];
    Log::info("message_uuid " . $message_uuid . " was " . $status . " at ". $timestamp);
});
