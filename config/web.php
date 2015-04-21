<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'mbt-news',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'e2adee221a14e7c21006f7be85954c8e',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                /*[
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api\news',
                    'except' => ['delete', 'create', 'update'],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api\tag',
                    'except' => ['delete', 'create', 'update'],
                    'extraPatterns' => [
                        'GET,HEAD' => 'all'
                    ]
                ],*/
                //API
                'GET,HEAD api/news/<id:\d+>' => 'api/news/view',
                'GET,HEAD api/news' => 'api/news/index',
                'api/news/<id>' => 'api/news/options',
                'api/news' => 'api/news/options',
                'GET,HEAD api/tag/<id:\d+>' => 'api/tag/view',
                'GET,HEAD api/tag/all' => 'api/tag/all',
                'GET,HEAD api/tag' => 'api/tag/index',
                'api/tag/<id>' => 'api/tag/options',
                'api/tag' => 'api/tag/options',
                //Admin
                'admin/<controller:\w+>/<action:\w+>'=>'admin/<controller>/<action>',
                //Users
                '<action:\w+>' => 'site/<action>',
                '' => 'site/index',
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
