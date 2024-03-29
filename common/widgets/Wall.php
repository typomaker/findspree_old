<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 10.03.15
 * Time: 1:22
 */

namespace common\widgets;


use common\helpers\String;
use common\models\Event;
use common\models\User;
use yii\base\Widget;

class Wall extends Widget
{
	/**
	 * @var \common\models\Wall
	 */
	public $model;
	/**
	 * @var User Пользователь для которого отображаем
	 */
	public $userView;

	public function run()
	{
		$class  = $this->model->getData()->className();
		$class  = String::onlyClassName($class);
		$data   = [];
		$method = 'prepare' . $class;
		if (method_exists($this, $method)) {
			$data = $this->{$method}();
		}
		$class  = String::camelToDash($class);
		$params = array_merge($data, ['model' => $this->model, 'userView' => $this->userView]);
		return $this->render('wall/' . $class, $params);
	}

	protected function prepareNewEvent()
	{
		/**
		 * @var  $data \common\models\Wall\EventCreate
		 */
		$data  = $this->model->getData();
		$user  = \Yii::$app->db->cache(function () use ($data) {
			return User::findOne($data->userId);
		}, 60);
		$event = \Yii::$app->db->cache(function () use ($data) {
			return Event::findOne($data->eventId);
		}, 60);
		return array_merge($data->toArray(), [
			'user'  => $user,
			'event' => $event,
		]);
	}

	protected function prepareSubscribeUser()
	{
		/**
		 * @var  $data \common\models\Wall\SubscribeUser
		 */
		$data     = $this->model->getData();
		$userTo   = \Yii::$app->db->cache(function () use ($data) {
			return User::findOne($data->to);
		}, 60);
		$userFrom = \Yii::$app->db->cache(function () use ($data) {
			return User::findOne($data->from);
		}, 60);
		return array_merge($data->toArray(), [
			'userTo'   => $userTo,
			'userFrom' => $userFrom,
		]);
	}

	protected function prepareSubscribeEvent()
	{
		/**
		 * @var  $data \common\models\Wall\SubscribeEvent
		 */
		$data  = $this->model->getData();
		$event = \Yii::$app->db->cache(function () use ($data) {
			return Event::findOne($data->eventId);
		}, 60);
		$user  = \Yii::$app->db->cache(function () use ($data) {
			return User::findOne($data->userId);
		}, 60);
		return array_merge($data->toArray(), [
			'event' => $event,
			'user'  => $user,
		]);
	}
}