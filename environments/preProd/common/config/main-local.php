<?php
return [
	'components' => [
		'db'     => [
			'class'    => 'yii\db\Connection',
			'dsn'      => 'mysql:host=localhost;dbname=vpiskin',
			'username' => 'root',
			'password' => '',
			'charset'  => 'utf8mb4',
		],
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			'viewPath' => '@common/mail',
			'useFileTransport' => true,
		],
	],
];
