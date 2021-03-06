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
        '<_a:login|logout>' => 'auth/auth/<_a>',
        'resend-email' => 'auth/verification/resend-email',
        'request-password' => 'auth/reset/request',

        'cabinet' => 'cabinet/default/index',

        '<_c:[\w\-]+>' => '<_c>/index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
        '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
    ],
];
