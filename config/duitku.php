<?php

return [
    'merchant_code' => env('DUITKU_MERCHANT_CODE'),
    'api_key' => env('DUITKU_API_KEY'),
    'api_url' => env('DUITKU_API_URL', 'https://sandbox.duitku.com'),
    'callback_url' => env('DUITKU_CALLBACK_URL', 'http://yourdomain.com/api/payment/callback'),
    'return_url' => env('DUITKU_RETURN_URL', 'http://yourdomain.com/payment/return'),
];