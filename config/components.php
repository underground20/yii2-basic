<?php

$db = require __DIR__ . '/db.php';
$routes = require __DIR__ . '/routes.php';

return [
    'request' => [
        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
        'cookieValidationKey' => 'tTkB3pJPVz-NwM7z8XhMZpYx4qmSCKLW',
        'enableCsrfValidation' => false
    ],
    'cache' => [
        'class' => 'yii\caching\FileCache',
    ],
    'user' => [
        'identityClass' => 'app\modules\user\models\User',
        'enableAutoLogin' => true,
    ],
    'view' => [
        'class' => 'yii\web\View',
        'renderers' => [
            'twig' => [
                'class' => 'yii\twig\ViewRenderer',
                'cachePath' => '@runtime/Twig/cache',
                'options' => [
                    'auto_reload' => true,
                ],
                'globals' => ['html' => '\yii\helpers\Html'],
                'uses' => ['yii\bootstrap'],
            ],
        ],
    ],
    'errorHandler' => [
        'errorAction' => '/main/site/error',
    ],
    'log' => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['error', 'warning'],
            ],
        ],
    ],
    'db' => $db,
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'enableStrictParsing' => false,
        'rules' => $routes
    ],
];