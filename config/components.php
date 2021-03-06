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
        'identityClass' => 'app\modules\user\models\Auth',
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
                'globals' => [
                    'html' => [
                        'class'=>'\yii\helpers\Html'
                    ]
                ],
                'uses' => ['yii\bootstrap'],
            ],
        ],
    ],
    'redis' => [
        'class' => 'yii\redis\Connection',
        'hostname' => 'redis',
        'port' => 6379,
        'database' => 0,
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
    'storage' => [
        'class' => 'app\components\Storage'
    ]
];