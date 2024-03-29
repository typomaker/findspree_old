<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php')
//    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'htmlLayout' => 'layouts/html',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'noreply@findspree.ru',
                'password' => 'eu6na012',
                'port' => '465',
                'encryption' => 'ssl',
            ]
        ],
		'urlManager'   => [
			'enablePrettyUrl' => true,
			'showScriptName'  => false,
			'rules'           => [
				'map'           => 'event/map',
				'user<id:\d+>'  => 'user/index',
				'event<id:\d+>' => 'event/view',
			],
		],
//        'request' => array(
//            'hostInfo' => 'http://localhost',
//            'baseUrl' => 'http://findspree.ru',
//            'scriptUrl' => 'index.php',
//        ),
    ],
    'params' => $params,
];
