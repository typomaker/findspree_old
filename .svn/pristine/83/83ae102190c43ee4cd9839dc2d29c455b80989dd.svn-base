<?php

namespace common\models;

use common\helpers\String;
use common\helpers\Time;
use common\models\Query\Event as EventQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "event".
 * @property integer                            $id
 * @property string                             $name
 * @property string                             $description
 * @property integer                            $user_id
 * @property integer                            $event_type_id
 * @property integer                            $created_at
 * @property integer                            $updated
 * @property string                             $begin
 * @property string                             $end
 * @property string                            $img
 * @property integer                            $status
 * @property integer                            $guests_expected
 * @property float                              $geo_longitude долгота
 * @property float                              $geo_latitude  широта
 * @property string                             $geo_title
 * @property string                             $geo_description
 * @property string                             $site
 * @property EventPrice[]                       $priceList
 * @property \common\models\User                $user
 * @property \common\models\User[]              $subscribers
 * @property \common\models\Tag[]               $tags
 * @property \common\models\EventType           $type
 */
class Event extends \yii\db\ActiveRecord
{
	const IMAGE_MAIN = 'main';
	const IMAGE_THUMB_MD = '200x';
	const IMAGE_THUMB_SM = '60x';
	const GROUP_FORTHCOMING = 0;
	const GROUP_FINISHED = 1;
	const GROUP_ALL = 100;
	const STATUS_ACTIVE = 0;
	const STATUS_DISABLE = 100;
	const STATUS_BLOCKED = 101;
	const STATUS_DELETED = 102;
	public $subscribe = false;

	public function behaviors()
	{
		return [
			[
				'class'              => TimestampBehavior::className(),
				'createdAtAttribute' => 'created_at',
				'updatedAtAttribute' => 'updated'
			],
		];
	}
	public function isCompleted(){
		$date = time();
		if(empty($this->end)){
			return $this->begin < $date;
		}else{
			return  $this->end < $date;
		}
	}
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'event';
	}

	/**
	 * @return \common\models\Query\Event;
	 */
	public static function find()
	{
		return new EventQuery(get_called_class());
	}
	public function isMy(){
		return $this->user_id == Yii::$app->user->getId();
	}
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['name', 'description', 'event_type_id', 'begin'], 'required'],
			//            [['id', 'id', 'created_at', 'geo_id', 'guests_expected'], 'integer'],
			[['begin'], 'safe'],
			[['name'], 'string', 'max' => 70],
			//			[['description'], 'string', 'max' => 2400]
		];
	}

	public function fields()
	{
		return [
			'id',
			'name',
			'f'         => function () {
				return [
					'begin' => Time::dateNormalize($this->begin),
					'end'   => Time::dateNormalize($this->end),
				];
			},
			'img'       => function () {
				return [
					'main' => $this->getImage(self::IMAGE_MAIN, ['onlyLink' => true]),
					'md'   => $this->getImage(self::IMAGE_THUMB_MD, ['onlyLink' => true]),
					'sm'   => $this->getImage(self::IMAGE_THUMB_SM, ['onlyLink' => true]),
				];
			},
			'link'      => function () {
				return [
					'subscribe' => Url::to(['/event/subscribe', 'id' => $this->id]),
					'view'      => Url::to(['/event/view', 'id' => $this->id]),
				];
			},
			'subscribe' => function () {
				return (bool)$this->subscribe;
			},
			'description',
			'geo_longitude',
			'begin',
			'end',
			'type'      => function () {
				return $this->type;
			},
			'site',
			'geo_latitude',
			'geo_title',
			'geo_description',
			'user',
			'tags'      => function () {
//				return Yii::$app->db->cache(function () {
				return $this->getTags()->indexBy(null)->select(['name'])->asArray()->column();
//				}, 3600);
			},
			'finished'  => function () {
				return $this->isCompleted();
			}
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id'              => 'Event ID',
			'name'            => 'Name',
			'description'     => 'Description',
			'user_id'         => 'User ID',
			'event_id'        => 'Event Type ID',
			'created_at'      => 'Created At',
			'begin'           => 'Begin',
			'geo_title'       => 'местонахождение',
			'guests_expected' => 'Guests Expected',
		];
	}

	/**
	 * @return ActiveQuery
	 */
	public function getPriceList()
	{
		return $this->hasMany(EventPrice::className(), ['event_id' => 'id'])->orderBy('cost');
	}

	public function getImageDir()
	{
		return Yii::$app->params['DIR_EVENT_IMG'] . '/' . $this->img;
	}

	public function getImage($size = self::IMAGE_MAIN, $options = [])
	{

		$options = array_merge([
								   'onlyLink'    => false,
								   'absoluteUrl' => false,
							   ], $options);
		$link = $this->getImageDir() . '/' . $size . '.jpeg';
		if ($options['absoluteUrl']) {
			$link = Url::base(true) . $link;
			unset($options['absoluteUrl']);
		}
		if ($options['onlyLink']) return $link;
		return Html::img($link, $options);
	}

	/**
	 * @return EventQuery
	 */
	public function getShows()
	{
		return $this->hasMany(EventShow::className(), ['event_id' => 'id']);
	}

	/**
	 * @return EventQuery
	 */
	public function getSubscribers()
	{
		return $this->hasMany(User::className(), ['id' => 'user_id'])
					->viaTable(EventSubscriber::tableName(), ['event_id' => 'id']);
	}

	public function getType()
	{
		return $this->hasOne(EventType::className(), ['id' => 'event_type_id']);
	}

	/**
	 * @return EventQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

	/**
	 * @return EventQuery
	 */
	public function getTags()
	{
		return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->indexBy('id')
					->viaTable(TagEvent::tableName(), ['event_id' => 'id']);
	}

	/**
	 * Вовзращает массив, где в качестве ключа указана дата а в значение кол-во событий в этот день
	 * @param int $days
	 * @return array
	 */
	public static function getNearest($days = 7)
	{
		$dt = new \DateTime(date('Y-m-d'));
		$param['now'] = $dt->getTimestamp();
		$param['end'] = $param['now'] + Time::SEC_TO_DAY * $days;
		$data = Yii::$app->db->cache(function () use ($param) {
			return static::find()
						 ->select([
									  'COUNT(*) as `count`',
									  'FROM_UNIXTIME(begin, \'%Y-%m-%d\') as `key`'
								  ])
						 ->where([
									 'and',
									 ['>=', 'begin', $param['now']],
									 ['<=', 'begin', $param['end']],
								 ])
						 ->orderBy('begin')
						 ->groupBy('key')
						 ->indexBy('key')
						 ->asArray()
						 ->all();
		}, 60);

		return ArrayHelper::getColumn($data, 'count');
	}
}
