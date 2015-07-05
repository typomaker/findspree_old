<?php
/**
 * Created by PhpStorm.
 * User: Альберт
 * Date: 08.05.2015
 * Time: 3:04
 */

namespace common\social\OAuth2;


use nodge\eauth\services\GoogleOAuth2Service;

class Google extends GoogleOAuth2Service {
	protected function fetchAttributes()
	{
		$info = $this->makeSignedRequest('https://www.googleapis.com/plus/v1/people/me');
//		$info = $this->makeSignedRequest('https://www.googleapis.com/oauth2/v1/userinfo');

		$this->attributes['id'] = $info['id'];
		$this->attributes['name'] = $info['displayName'];
		$this->attributes['email'] = $info['emails'][0]['value'];
	}
}