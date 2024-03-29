<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 22.02.15
 * Time: 3:58
 */

namespace frontend\models;


use common\helpers\Arr;
use common\helpers\Time;
use common\models\Event;
use common\models\EventHistory;
use common\models\EventPrice;
use common\models\Tag;
use common\models\User;
use common\models\Wall;
use common\models\Wall\EventCreate;
use common\models\Wall\EventEdit;
use common\models\WallPost;
use common\models\EventSubscriber;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;

class EventForm extends Model
{
	const SCENARIO_INSERT='insert';
	const SCENARIO_EDIT='edit';
	const TAG_MAX_COUNT = 5;
	public  $name;
	public  $description;
	public  $begin;
	public  $end;
	public  $type;
	public  $geoCoordinates;
	public  $geoTitle;
	public  $geoDescription;
	private $_price = [];
	private $_eventModel;
	public  $site;
	/**
	 * @var UploadedFile
	 */
	public $img;
	public $tag;

	public function rules()
	{
		return [
			[
				['name', 'description', 'geoTitle', 'geoDescription', 'geoCoordinates', 'begin'],
				'required','on' =>[ self::SCENARIO_INSERT,self::SCENARIO_EDIT ]
			],
			['img', 'required', 'on' => self::SCENARIO_INSERT],
			[
				['name', 'geoTitle', 'geoDescription', 'geoCoordinates', 'site', 'description'],
				'filter',
				'filter' => function ($value) {
					return htmlspecialchars(trim($value));
				}
			],
			[['site',], 'url', 'defaultScheme' => 'http', 'message' => 'Введите корректный адрес сайта'],
			//			[['price'], 'number', 'min' => 0, 'message' => 'Цена не может быть меньше нуля'],
			[['type'], 'integer'],
			[['name'], 'string', 'max' => 70],
			[['site'], 'string', 'max' => 100],
			[['description'], 'string', 'max' => 8000],
			['tag','match','pattern'=>'#^[0-9a-zа-яё_\s,\#.-]*$#iu'],
			[['end','begin'], 'match','pattern'=>"#^[0-9]{2}\\.[0-9]{2}\\.[0-9]{4} [0-9]{2}:[0-9]{2}$#"],
			[
				'img',
				'image',
				'minWidth'    => 300,
				'minHeight'   => 100,
				'maxWidth'    => 3840,
				'maxHeight'   => 3840,
				'mimeTypes'   => 'image/jpg, image/jpeg, image/png, image/gif',
				'extensions'  => ['jpg', 'jpeg', 'png', 'gif'],
				'maxSize'     => (1024 * 5 * 1024),
				'underWidth'  => 'Изображение слишком маленькое по ширине, не менее 300px',
				'underHeight' => 'Изображение слишком маленькое по высоте, не менее 100px',
				'overHeight'  => 'Изображение слишком большое по высоте, не более 3840px',
				'overWidth'   => 'Изображение слишком большое по ширине, не более 3840px'
			],
		];
	}


	public function attributeLabels()
	{
		return [
			'name'        => 'Название',
			'description' => 'Описание',
			'type'        => 'Категория',
			'begin'       => 'Дата начала',
			'end'         => 'Дата окончания',
			'geoTitle'    => 'Адрес',
			'tag'         => 'Теги',
			'site'        => 'Сайт события',
			'price'       => 'Стоимость',
		];
	}

	/**
	 * @return EventPrice[]
	 */
	public function getPrice()
	{
		$result = [];
		foreach ($this->_price as $dt) {
			$result[] = new EventPrice($dt);
		}
		return $result;
	}

	/**
	 * @param array $list
	 */
	public function setPrice(array $list)
	{
		$this->_price = $list;
	}

	/**
	 * Устанавливаем существующую модель
	 * @param Event $event
	 */
	public function setEventModel(Event $event)
	{
		$this->_eventModel = $event;
		$this->geoDescription = $event->geo_description;
		$this->geoCoordinates = $event->geo_longitude . ',' . $event->geo_latitude;
		$this->type = $event->event_type_id;
		$this->name = $event->name;
		$this->description = $event->description;
		$this->begin = Time::toDateTime($event->begin)->format('d.m.Y H:i');
		if ($event->end) {
			$this->end = Time::toDateTime($event->end)->format('d.m.Y H:i');
		}
		$this->img = $event->getImage(Event::IMAGE_MAIN, ['onlyLink' => 1]);
		$this->site = $event->site;
		$tags = ArrayHelper::getColumn($event->tags, 'name');
		$this->tag = implode(', ', $tags);
		$this->setPrice($event->getPriceList()->asArray()->all());
	}

	public function load($data, $formName = null)
	{
		if (!parent::load($data, $formName)) {
			return false;
		}
		$this->setPrice(isset($_POST['EventPrice']) ? $_POST['EventPrice'] : []);

		return true;
	}

	public function save()
	{
		/**
		 * @var User $user
		 */
		$user = \Yii::$app->user->identity;
		$event = $this->_eventModel ?: new Event();
		if(preg_match_all('/[^\s,]+/iu',$this->tag,$tags)){
			$tags = array_slice($tags[0],0,self::TAG_MAX_COUNT);
		}else{
			$tags = [];
		}
		$historyData = [
			'before'=>'',
			'after'=>'',
			'event_id'=>'',
			'action'=>EventHistory::ACTION_CREATE,
		];
		$before = [];
		if (!$event->isNewRecord) {
			$historyData['action'] = EventHistory::ACTION_EDIT;
			$before = $event->getAttributes();
			unset($before['updated']);
			$tagsOld = ArrayHelper::getColumn($event->tags, 'name',false);
			$before['tags']= $tagsOld;
			$before['priceList']=$event->getPriceList()->asArray()->select(['cost','description'])->all();
			Tag::unbind($event,$tagsOld);
			EventPrice::deleteAll(['event_id' => $event->id]);
			FileHelper::removeDirectory($event->getImageDir());
		}
		$event->geo_description = $this->geoDescription;
		$event->geo_title = $this->geoTitle;
		list($event->geo_longitude, $event->geo_latitude) = explode(',', $this->geoCoordinates);
		//сохраняем картиночку
		$uploadedFile = $this->img;
		if ($uploadedFile) {
			$basePath = \Yii::getAlias('@webroot') . \Yii::$app->params['DIR_EVENT_IMG'];
			$folderName = sha1(uniqid(mt_rand(), true) . ':' . $user->id . ':' . $uploadedFile->name);
			$dir = $basePath . DIRECTORY_SEPARATOR . $folderName;
			$main = Image::getImagine()->open($uploadedFile->tempName);
			FileHelper::createDirectory($dir);
			$main->copy()
				 ->thumbnail(new Box(200, 200), ImageInterface::THUMBNAIL_OUTBOUND)
				 ->save($dir . '/' . Event::IMAGE_THUMB_MD . '.jpeg');
			$main->copy()
				 ->thumbnail(new Box(60, 60), ImageInterface::THUMBNAIL_OUTBOUND)
				 ->save($dir . '/' . Event::IMAGE_THUMB_SM . '.jpeg');
			if($main->getSize()->getHeight()/$main->getSize()->getWidth() >= 1.9){
				$main->thumbnail(new Box(600, 600), ImageInterface::THUMBNAIL_OUTBOUND)->save(
					$dir . '/' . Event::IMAGE_MAIN . '.jpeg'
				);
			}else{
				$main->resize($main->getSize()->widen(600))->save($dir . '/' . Event::IMAGE_MAIN . '.jpeg');
			}
			unlink($uploadedFile->tempName);
			$event->img = $folderName;
		}
		$event->event_type_id = $this->type;
		$event->user_id = $user->id;
		$event->name = $this->name;
		$event->description = $this->description;
		$event->begin = (new \DateTime($this->begin))->getTimestamp(); //todo приводим дату к нормальному виду
		if ($this->end) {
			$event->end = (new \DateTime($this->end))->getTimestamp(); //todo приводим дату к нормальному виду
		}
		$event->site = $this->site;
		if ($event->save()) {
			$after = $event->getAttributes();
			unset($after['updated']);

			$wall = new Wall();
			$eventWallParams = [
				'userId'  => $user->id,
				'eventId' => $event->id
			];
			if ($this->getScenario() != self::SCENARIO_EDIT) {
				$wall->setData(new EventCreate($eventWallParams));
			}
			else {
				$wall->setData(new EventEdit($eventWallParams));
			}
			$wall->publishTo(new WallPost([
											  'target_type' => WallPost::TARGET_TYPE_USER,
											  'target_id'   => $user->id,
											  'personal'    => false
										  ]));
			$subscribers = $user->getSubscribers()->select('subscriber_id')->column();
			if ($subscribers) {
				foreach ($subscribers as $userSub) {
					$wall->publishTo(new WallPost([
													  'target_type' => WallPost::TARGET_TYPE_USER,
													  'target_id'   => $userSub,
													  'personal'    => true
												  ]));
				}
			}
			$wall->save();
			$i = 1;
			$priceCheck = [];
			foreach ($this->getPrice() as $ep) {
				$ep->event_id = $event->id;
				if ($ep->validate() && is_numeric($ep->cost) && !in_array((int)$ep->cost, $priceCheck)) {
					$priceCheck[] = (int)$ep->cost;
					$ep->insert(false);
					$after['priceList'][]=['cost'=>$ep->cost,'description'=>$ep->description];
				}
				if ($i == 10) break;
				$i++;
			}
			Tag::bind($event, $tags);
			$historyData['event_id']=$event->id;
			$after['tags']=$tags;
			$diff = Arr::diff($before, $after);
			$historyData = array_merge($historyData, $diff);
			$historyData['before'] = isset($historyData['before'])?json_encode($historyData['before']):'';
			$historyData['after'] = isset($historyData['after'])?json_encode($historyData['after']):'';
			$history = new EventHistory($historyData);
			$history->insert(false);
			return $event->id;
		}
		return false;
	}

	/**
	 * @param $event_id
	 *       Уведомлеие всех подписчиков мероприятия по емайл при отмеченной галке "Оповестить всех подписчиков" при
	 *       отправке коммента
	 * @todo это наверное лучше перенести именно в метод добавления коммента? В модель создания комментария, в
	 *       afterInsert
	 */
	public static function commenatAllNotification($event_id, $message)
	{
		$Subscribers = EventSubscriber::find()->with('user')->where(['event_id' => $event_id])->all();
		$Event = Event::findOne(['id' => $event_id]);
		foreach ($Subscribers as $User) {
			$messages[] = \Yii::$app->mailer->compose('message-all-notify', [
				'msg'      => htmlspecialchars($message),
				'notifier' => \Yii::$app->user->identity
			])
											->setFrom('noreply@findspree.ru')
											->setTo($User->user->email)
											->setSubject('Оповещение от владельца мероприятия "' . $Event->name . '"');
		}
		if (isset($messages) && !empty($messages)) \Yii::$app->mailer->sendMultiple($messages);
	}
}