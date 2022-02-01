<?php

return [
    'class' => 'yii\web\UrlManager',
    'hostInfo' => 'frontendHostInfo',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'site/index',
        'about' => 'site/about',
        'contact' => 'contact/index',
        'singup' => 'auth/singup/index',
        'singup/<_a:[\w-]+>' => 'auth/singup/<_a>',
        '<_a:login|logout>' => 'auth/auth/<_a>',
        'resend-email' => 'auth/verification/resend-email',
        'request-password' => 'auth/reset/request',

        '<_c:[\w\-]+>' => '<_c>/index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
        '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
    ],
];
