<?php

return [
    'mode' => 'sandbox',
    'service.EndPoint' => 'https://api.sandbox.paypal.com', // <- change later to production
    'http.ConnectionTimeOut' => 30,
    'log.LogEnabled' => true,
    'log.FileName' => storage_path('logs/paypal.log'), // <- Logging here
    'log.LogLevel' => 'FINE'
];