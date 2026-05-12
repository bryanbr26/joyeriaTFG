<?php

return [
    'environment' => env('REDSYS_ENVIRONMENT', 'sandbox'),

    'merchant_code' => env('REDSYS_MERCHANT_CODE', '999008881'),
    'terminal' => env('REDSYS_TERMINAL', '001'),
    'secret_key' => env('REDSYS_SECRET_KEY', 'sq7HjrUOBfKmC576ILgskD5srU870gJ7'),

    'currency' => env('REDSYS_CURRENCY', '978'),
    'transaction_type' => env('REDSYS_TRANSACTION_TYPE', '0'),
    'signature_version' => 'HMAC_SHA512_V2',

    'sandbox_url' => 'https://sis-t.redsys.es:25443/sis/realizarPago',
    'production_url' => 'https://sis.redsys.es/sis/realizarPago',
];
