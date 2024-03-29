<?php

namespace common\models;

use common\component\Request;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "event_show".
 * @property string  $id
 * @property integer $event_id
 * @property string  $ip
 * @property string  $created
 * @property string  $user_id
 * @property string  $referrer
 */
class EventShow extends \yii\db\ActiveRecord
{
	public function behaviors()
	{
		return [
			[
				'class'              => TimestampBehavior::className(),
				'createdAtAttribute' => 'created',
				'updatedAtAttribute' => false,
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'event_show';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['event_id', 'uniqid'], 'required'],
			[['event_id'], 'integer'],
			[['uniqid'], 'string', 'max' => 40],
			[['uniqid'], 'unique']
		];
	}

	public static function showed(Event $event)
	{
		/**
		 * @var $request Request
		 */
		$q = self::find();
		$request = Yii::$app->request;
		if ($request->getIsRobot()) {
			return null;
		}
		$ip = Yii::$app->request->getUserIP()?ip2long(Yii::$app->request->getUserIP()):null;
		$userId = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
		if(!$ip){
			return false;
		}
		$q->where(
			[
				'and',
				[
					'or',
					['=', 'ip', $ip],
					['=', 'user_id', $userId]
				],
				['=', 'event_id', $event->id]
			]
		);
		if (!$q->exists()) {
			$obj = new static();
			$obj->ip = $ip;
			$obj->user_id = $userId;
			$obj->event_id = $event->id;
			$obj->referrer = $request->getReferrer();
			return $obj->insert(false);
		}
		return false;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id'       => 'ID',
			'event_id' => 'Event ID',
			'uniqid'   => 'Uniqid',
		];
	}
}
