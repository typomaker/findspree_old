<?php

$config = [
	'components' => [
		'request' => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => '',
		],
		'eauth'   => [
			'class'       => 'nodge\eauth\EAuth',
			'popup'       => true,
			// Use the popup window instead of redirecting.
			'cache'       => false,
			// Cache component name or false to disable cache. Defaults to 'cache' on production environments.
			'cacheExpire' => 0,
			// Cache lifetime. Defaults to 0 - means unlimited.
			'httpClient'  => [
				// uncomment this to use streams in safe_mode
				//'useStreamsFallback' => true,
			],
			'services'    => [ // You can change the providers and their classes.
							   'vkontakte'    => [
								   // register your app here: https://vk.com/editapp?act=create&site=1
								   'class'        => 'common\social\OAuth2\Vk',
								   'clientId'     => '4903834',
								   'clientSecret' => 'XcbdH2H4f4japrmeZL3L',
								   //									 'scope'=>['friends','email','nohttps']
								   'scope'        => ['friends', 'email']
							   ],
							   'facebook'     => [
								   'class'        => 'nodge\eauth\services\extended\FacebookOAuth2Service',
								   'clientId'     => '1004263189586829',
								   'clientSecret' => '63b52a9faf46163f615042ae54b28bdc',
								   //									 'scope'=>['hometown','email','location','photos','birthday']
							   ],
							   'google_oauth' => [
								   // register your app here: https://code.google.com/apis/console/
								   'class'        => 'common\social\OAuth2\Google',
								   'clientId'     => '187710509983-esid261slcbl628pb5uot7gegkbma4ob.apps.googleusercontent.com',
								   'clientSecret' => 'Oe4JuQ3tGM9D6Qfs0gK3h8uk',
								   'title'        => 'Google (OAuth)',
								   'scope'        => ['profile', 'email']
							   ],
			],
		],
	],
];

if (!YII_ENV_TEST) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = 'yii\debug\Module';

	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
