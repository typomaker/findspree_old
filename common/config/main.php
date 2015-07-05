<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'session' => [
			'class' => 'yii\web\DbSession',
		],
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			'viewPath' => '@common/mail',
			'useFileTransport' => true,
		],
    ],
];
