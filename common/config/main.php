<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'usa.am',
                'username' => 'forms@usa.am',
                'password' => 'eUGKBBSXGfE67FJM!',
                'port' => '25',
                'encryption' => 'TLS',
            ],
        ],
    ],
];
