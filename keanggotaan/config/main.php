<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$modules = array_merge(
       require(__DIR__ . '/modules.php')
);

return [
    'id' => 'app-keanggotaan-inlislite',
    'basePath' => dirname(__DIR__),
    'language' => 'id',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'keanggotaan\controllers',
    'components' => [
        'request' => [
            'cookieValidationKey' => 'inlislitev3',
            'csrfParam' => '_keanggotaanInlislite',
        ],
       
        'view' => [
            'theme' => 'inliscore\adminlte\Theme',
        ],
        'user' => [
            'identityClass' => 'common\models\UserMemberOnlines',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_keanggotaanUser', // unique for backend
                'path' => '/keanggotaan' // set it to correct path for backend app.
            ]
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
            'name' => 'keanggotaanSession',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ]
    ],
    'params' => $params,
    'modules'=> $modules,
];
