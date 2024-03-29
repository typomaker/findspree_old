<?php
/**
 * Created by PhpStorm.
 * User: Альберт
 * Date: 07.05.2015
 * Time: 4:09
 */

namespace common\social\OAuth2;


use common\models\User;
use nodge\eauth\services\extended\VKontakteOAuth2Service;

class Vk extends VKontakteOAuth2Service
{
	const SCOPE_EMAIL = 'email';
	const SCOPE_NOHTTPS = 'nohttps';

	protected function fetchAttributes()
	{
		$tokenData = $this->getAccessTokenData();
		$email = isset($tokenData['params']['email'])?$tokenData['params']['email']:'';
		$info = $this->makeSignedRequest('users.get.json', array(
			'query' => array(
				'uids' => $tokenData['params']['user_id'],
				//'fields' => '', // uid, first_name and last_name is always available
				'fields' => 'nickname, sex, bdate, city, country, timezone, photo, photo_medium, photo_big, photo_rec',
			),
		));
		$info = $info['response'][0];

		$this->attributes = $info;
		$this->attributes['id'] = $info['uid'];
		$this->attributes['name'] = $info['first_name'] . ' ' . $info['last_name'];
		$this->attributes['url'] = 'http://vk.com/id' . $info['uid'];
		$this->attributes['email'] = $email;

		if (!empty($info['nickname'])) {
			$this->attributes['username'] = $info['nickname'];
		} else {
			$this->attributes['username'] = 'id' . $info['uid'];
		}

		$this->attributes['gender'] = $info['sex'] == 1 ? User::GENDER_FEMALE : User::GENDER_MALE;

		if (!empty($info['timezone'])) {
			$this->attributes['timezone'] = timezone_name_from_abbr('', $info['timezone'] * 3600, date('I'));
		}

		return true;
	}
}