<?php

use kartik\datecontrol\Module;

return [
    'adminEmail' => 'soporte.venenciame@gmail.com',
    'senderEmail' => 'venenciame',
    'senderName' => 'Vennénciame',
    'smtpUsername' => 'soporte.venenciame@gmail.com',

    'bsVersion' => '4.x',

    'dateControlDisplay' => [
        Module::FORMAT_DATE => 'php:d-m-Y',
        Module::FORMAT_TIME => 'php:H:i:s',
        Module::FORMAT_DATETIME => 'php:d-m-Y H:i:s',
    ],
    'dateControlSave' => [
        Module::FORMAT_DATE => 'php:Y-m-d',
        Module::FORMAT_TIME => 'php:H:i:s',
        Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
    ],

    'payPalClientId'=> getenv('PAYPAL_ID'),
    'payPalClientSecret'=>getenv('PAYPAL_SECRET'),
];
