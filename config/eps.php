<?php

return [
    'merchant_key'  => env('EPS_MERCHANT_KEY'),
    'secret_key'    => env('EPS_SECRET_KEY'),
    'client_api'    => env('EPS_CLIENT_API'),
    'environment'    => env('EPS_ENV'),
    'status' => [
        "201" => "Payment is in the processing queue",
        "203" => "Payment in the processing",
        "204" => "Payment is rejected",
        "205" => "Payment has been successfully completed",
        "206" => "Waiting for payment by the payer",
        "207" => "Payment is returned",
        "401" => "Invalid hash of request",
        "402" => "Invalid Payee ID Key",
        "404" => "Mandatory attribute is missing",
        "405" => "Invalid attribute format",
        "474" => "Payment with the specified parameters is not found",
        "500" => "Internal server error",
        "999" => "Unknown status, contact support"
    ]
];
