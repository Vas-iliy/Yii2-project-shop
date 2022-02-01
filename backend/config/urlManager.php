<?php

return [
    'class' => 'yii\web\UrlManager',
    'hostInfo' => 'backendHostInfo',

    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'user/index',
        '<_a:logout|login>' => 'user/<_a>',

        '<_c:[\w\-]+>' => '<_c>/index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
        '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
    ],
];
