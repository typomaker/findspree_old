<?php

namespace frontend\controllers;

use common\component\Controller;
use common\helpers\Time;
use common\models\Event;
use common\models\EventShow;
use common\models\EventSubscriber;
use common\models\EventType;
use common\models\Wall;
use common\models\Wall\SubscribeEvent;
use common\models\WallPost;
use frontend\models\EventForm;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class EventController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['index', 'view', 'event-subscribers', 'map'],
						'allow'   => true,
						'roles'   => ['?'],
					],
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	/**
	 * Страница просмотра события
	 * @return string
	 */
	public function actionIndex()
	{
		$_GET = $filters = array_merge([
										   'begin'  => null,
										   'end'    => null,
										   'tag'    => null,
										   'type'   => null,
										   'act'    => Event::GROUP_FORTHCOMING,
										   'search' => '',
									   ], $_GET);

		\Yii::$app->response->format = Response::FORMAT_JSON;
		$dp = new ActiveDataProvider();
		$dp->query = Event::find()->checkSubscribe()->active()->with('user')->orderBy(['begin' => SORT_ASC]);
		if ($filters['act'] == Event::GROUP_FORTHCOMING) {
			$dp->query->andWhere([
									 'or',
									 ['>', 'end', time()],
									 [
										 'and',
										 ['end' => null],
										 ['>', 'begin', time()]
									 ],
								 ]);
		}
		elseif ($filters['act'] == Event::GROUP_FINISHED) {
			$dp->query->andWhere([
									 'or',
									 [
										 'and',
										 ['<', 'begin', time()],
										 ['end'=> null],
									 ],
									 [
										 'and',
										 ['<', 'begin', time()],
										 ['<', 'end', time()],
									 ],
								 ]);
		}
		if ($filters['begin']) {
			$begin = (new \DateTime($filters['begin']))->getTimestamp();
			$end = (new \DateTime($filters['begin']))->modify('+1 day')->setTime(0, 0, 0)->getTimestamp();
			$dp->query->andFilterWhere([
										   'and',
										   ['>=', 'begin', $begin],
										   ['<', 'begin', $end],
									   ]);
		}
		if ($filters['search']) {
			$dp->query->andWhere('MATCH (event.name,event.geo_description,event.description) AGAINST (:text)', ['text' => $filters['search']]);
		}
		$dp->query->andFilterWhere(['event_type_id' => $filters['type']]);
		if ($filters['tag']) {
			$dp->query->joinWith('tags', false);
			$dp->query->andFilterWhere(['tag.name' => $filters['tag']]);
		}
		$dp->pagination->pageSize = 16;
		return $this->renderCollection($dp);
	}

	/**
	 * Страница создания события
	 */
	public function actionEdit($id = null)
	{
		\Yii::$app->user->setReturnUrl(['event/edit']);
		$user = \Yii::$app->getUser()->identity;
		$model = new EventForm();
		$model->setScenario(EventForm::SCENARIO_INSERT);
		if ($id) {
			$event = Event::findOne(['id' => $id, 'user_id' => $user->getId()]);
			if (!$event) throw new NotFoundHttpException;
			$model->setEventModel($event);
			$model->setScenario(EventForm::SCENARIO_EDIT);
		}
		if ($model->load($_POST)) {
			$model->img = UploadedFile::getInstance($model, 'img');
			if ($model->validate() && $id = $model->save()) {
				$this->redirect(['event/view', 'id' => $id]);
				\Yii::$app->end();
			}
		}
		$eventTypeList = EventType::find()->indexBy('id')->all();
		return $this->render('new', ['model' => $model, 'user' => $user, 'eventTypeList' => $eventTypeList]);
	}

	/**
	 * Страница просмотра события
	 */
	public function actionView($id)
	{
		\Yii::$app->user->setReturnUrl(['event/view', 'id' => $id]);
		$event = Event::find()->checkSubscribe()->where(['event.id' => $id])->one();
		if (!$event) throw new NotFoundHttpException();
		EventShow::showed($event);
		if (\Yii::$app->request->isAjax) return $this->renderPartial('/event/view-info.php', ['event' => $event]);
		return $this->render('view', ['event' => $event]);
	}

	/**
	 * @param $id
	 * @return array
	 * @throws NotFoundHttpException
	 * @throws \Exception
	 * Подписка на событие
	 */
	public function actionSubscribe($id)
	{
		if (!$id or !\Yii::$app->request->isAjax) {
			throw new NotFoundHttpException;
		}
		$userId = \Yii::$app->user->identity->id;
		$subscribed = EventSubscriber::find()->where(['event_id' => $id, 'user_id' => $userId])->one();
		if ($subscribed) {
			$delete = $subscribed->delete();
			$result = ['error' => !$delete, 'message' => 'Вы отписались от события.'];
		}
		else {
			$model = new EventSubscriber();
			$model->event_id = $id;
			$model->user_id = $userId;
			$result = ['error' => !$model->save(), 'message' => 'Вы успешно подписаны на событие.'];
		}
		return $this->renderJson($result);
	}

	/**
	 * @param $event_id
	 * @return array Вывод подписчиков на страницу события
	 * Вывод подписчиков на страницу события
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionEventSubscribers($event_id)
	{
		if (!\Yii::$app->request->isAjax) {
			throw new NotFoundHttpException;
		}
		\Yii::$app->response->format = Response::FORMAT_JSON;
		$dp = new ActiveDataProvider();
		$dp->query = EventSubscriber::find()
									->with('user')
									->where(['event_id' => $event_id])
									->orderBy(['id' => SORT_DESC]);
		$dp->pagination->pageSize = 12;
		return [
			'items'      => $dp->getModels(),
			'pageCount'  => $dp->getPagination()->getPageCount(),
			'totalCount' => $dp->getTotalCount(),
			'page'       => $dp->pagination->page,
			'count'      => $dp->getCount(),
		];
	}

	public function actionMap()
	{
		if (\Yii::$app->request->isAjax) {
			return $this->renderJson(Event::find()->where('begin > ' . time())->all());
		}
		return $this->render('map');
	}

	public function actionSave($event_id, $user_id, $type)
	{
		if (!\Yii::$app->request->isAjax) {
			$this->redirect(['']);
		}
		if ($type == 'edit-description') {
			$Event = Event::findOne(['id' => $event_id, 'user_id' => $user_id]);
			if (!$Event) throw new HttpException(403);
			$Event->description = nl2br(trim(htmlspecialchars($_POST['description'])));
			$Event->save();
			return $this->renderJson(html_entity_decode($Event->description));
		}
	}
}
