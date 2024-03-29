<?php
use common\helpers\Time;
use himiklab\sitemap\behaviors\SitemapBehavior;
use nodge\eauth\services\GoogleOAuth2Service;

$params = array_merge(require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php'));

return [
	'id'                  => 'app-frontend',
	'basePath'            => dirname(__DIR__),
	'language'            => 'ru_RU',
	'bootstrap'           => ['log'],
	'name'                => 'findspree',
	'controllerNamespace' => 'frontend\controllers',
	'modules'             => [
		'sitemap' => [
			'class'       => 'himiklab\sitemap\Sitemap',
			'models'      => [
				[
					'class'     => \common\models\Event::className(),
					'behaviors' => [
						'sitemap' => [
							'class'       => SitemapBehavior::className(),
							'scope'       => function ($model) {
								/** @var \yii\db\ActiveQuery $model */
								$model->select(['id', 'created_at', 'updated']);
								return $model->where(['>', 'begin', time() - Time::SEC_TO_MONTH]);
							},
							'dataClosure' => function ($model) {
								/** @var \common\models\Event $model */
								return [
									'loc'        => \yii\helpers\Url::to(['/event/view', 'id' => $model->id], true),
									'lastmod'    => $model->updated ?: $model->created_at,
									'changefreq' => SitemapBehavior::CHANGEFREQ_DAILY,
									'priority'   => $model->begin > time() ? 1 : 0.5
								];
							}
						],
					],
				],
			],
			'enableGzip'  => true,
			'cacheExpire' => Time::SEC_TO_HOUR,
		],
	],
	'components'          => [
		'i18n' => [
			'translations' => [
				'eauth' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@eauth/messages',
				],
			],
		],
		'user'         => [
			'identityClass'   => 'common\models\User',
			'enableAutoLogin' => true,
		],
		'log'          => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets'    => [
				[
					'class'  => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'urlManager'   => [
			'enablePrettyUrl' => true,
			'showScriptName'  => false,
			'rules'           => [
				'events'        => '/site/index',
				'map'           => 'event/map',
				'user<id:\d+>'  => 'user/index',
				'my'            => 'user/index',
				'event<id:\d+>' => 'event/view',
				['pattern' => 'sitemap', 'route' => 'sitemap/default/index', 'suffix' => '.xml'],
			],
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'cache'        => [
			'class' => 'yii\caching\FileCache',
		],
		'request' => [
			'class' => \common\component\Request::className(),
		],
		'mailer'       => [
			'class'            => 'yii\swiftmailer\Mailer',
			'viewPath'         => '@app/mail',
			'htmlLayout'       => 'layouts/html',
			'useFileTransport' => false,
			'transport'        => [
				'class'      => 'Swift_SmtpTransport',
				'host'       => 'smtp.yandex.ru',
				'username'   => 'noreply@findspree.ru',
				'password'   => 'eu6na012',
				'port'       => '465',
				'encryption' => 'ssl',
			],
		],
	],
	'params'              => $params,
];
