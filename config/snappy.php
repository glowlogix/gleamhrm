<?php

return [
    'pdf' => [
        'enabled' => true,
        'binary' => base_path('vendor\wemersonjanuario\wkhtmltopdf-windows\bin\64bit\wkhtmltopdf'),
        'timeout' => false,
        'options' => [],
        'env' => [],
    ],
    'image' => [
        'enabled' => true,
        'binary' => 'vendor\wemersonjanuario\wkhtmltopdf-windows\bin\64bit\wkhtmltoimage',
        'timeout' => false,
        'options' => [],
        'env' => [],
    ],

    // For linux comment out above code and uncomment below code
    // 'pdf' => [
    //     'enabled' => true,
    //     'binary' => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),
    //     'timeout' => false,
    //     'options' => [],
    //     'env' => [],
    // ],
    // 'image' => [
    //     'enabled' => true,
    //     'binary' => 'vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64',
    //     'timeout' => false,
    //     'options' => [],
    //     'env' => [],
    // ],
];
