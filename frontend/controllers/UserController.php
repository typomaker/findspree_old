<?php

namespace frontend\controllers;

use common\component\Controller;
use common\models\User;
use common\models\UserSubscriber;
use common\models\Wall;
use common\models\WallPost;
use frontend\models\AvatarForm;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

class UserController extends Controller
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
                        'actions' => ['index', 'wall', 'signed', 'subscribers','events-subscribe','events-created'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionEdit()
    {
        return $this->render('edit');
    }

    public function actionAvatarChange()
    {
        $user = \Yii::$app->user->identity;
        $avatar = new AvatarForm();
        if ($avatar->load($_POST)) {
            if(\Yii::$app->request->isAjax){
                return ActiveForm::validate($avatar);
            }
            $avatar->img = UploadedFile::getInstance($avatar, 'img');
            if ($avatar->validate()) {
                $avatar->save($user);
                return $this->redirect('index');
            }
        }
        return $this->render('avatar-change', ['user' => $user, 'avatar' => $avatar]);
    }

    public function actionIndex($id = null)
    {
		\Yii::$app->user->setReturnUrl(['user/index','id'=>$id]);
        $userView = $id && \Yii::$app->user->identity != $id ? User::findOne($id) : \Yii::$app->user->identity;
        if (!$userView) {
            throw new NotFoundHttpException();
        }
        return $this->render('index', [
            'userAuth' => \Yii::$app->user->identity,
            'userView' => $userView,
        ]);
    }

	/**
	 * На кого подписан
	 * @param $id int ид пользователя
	 * @return
	 * @throws NotFoundHttpException
	 */
	public function actionSigned($id){
		/**
		 * @var User $user
		 */
		$user = $id == \Yii::$app->user->getId()?\Yii::$app->user->identity:User::findOne($id);
		if(!$user){
			throw new NotFoundHttpException;
		}
		$dataProvider = new ActiveDataProvider();
		$dataProvider->query = User::find()->leftJoin(UserSubscriber::tableName(),'user_subscriber.user_id=user.id')->where('user_subscriber.subscriber_id=:id and user_subscriber.id > 0',['id'=>$id]);
		return $this->renderCollection($dataProvider);
	}

	public function actionSubscribers($id){
		/**
		 * @var User $user
		 */
		$user = $id == \Yii::$app->user->getId()?\Yii::$app->user->identity:User::findOne($id);
		if(!$user){
			throw new NotFoundHttpException;
		}
		$dataProvider = new ActiveDataProvider();
		$dataProvider->query = User::find()->leftJoin(UserSubscriber::tableName(),'user_subscriber.subscriber_id=user.id')->where('user_subscriber.user_id=:id and user_subscriber.id > 0',['id'=>$id]);
		return $this->renderCollection($dataProvider);
	}

    public function actionWall($id = null)
    {
        /**
         * @var $userView User
         */
        $userView = $id && \Yii::$app->user->identity != $id ? User::findOne($id) : \Yii::$app->user->identity;
        if (!$userView) {
            throw new NotFoundHttpException();
        }
        $collection = new ActiveDataProvider();
        $collection->pagination->pageSize = 12;
        $criteria = [
            'and',
            'wall.id=wall_post.wall_id',
            ['=', 'target_type', WallPost::TARGET_TYPE_USER],
            ['=', 'target_id', $userView->id],
        ];
        if(!$userView->isMy()){
            $criteria[]=['=','personal',0];
        }
        $collection->query = Wall::find()
            ->select('wall.*')
            ->innerJoin(WallPost::tableName(), $criteria)
            ->orderBy('wall.id DESC');
        return $this->renderCollection($collection);
    }

	/**
	 * Воазращает список событий, на которые пользователь подписан
	 * @param $id Ид пользователя
	 * @return mixed
	 * @throws NotFoundHttpException
	 */
    public function actionEventsSubscribe($id)
    {
        if (!\Yii::$app->request->isAjax)
            throw new NotFoundHttpException;
        $params = array_merge([
            'pageSize' => 12
        ], $_GET);
        $user = User::findOne($id);
        if (!$user)
            throw new NotFoundHttpException;
        $dp = new ActiveDataProvider();
        $dp->getPagination()->pageSize = $params['pageSize'];
        $dp->query = $user->getEventSubscribe()->checkSubscribe()->orderBy('event.id DESC');
        return $this->renderCollection($dp);
    }

	/**
	 * Возвращает созданные события
	 * @param $id Ид пользователя
	 * @return mixed
	 * @throws NotFoundHttpException
	 */
    public function actionEventsCreated($id)
    {
		/**
		 * @var User $user
		 */
        if (!\Yii::$app->request->isAjax)
            throw new NotFoundHttpException;
        $params = array_merge([
            'pageSize' => 12
        ], $_GET);

        $user = User::findOne($id);
        if (!$user)
            throw new NotFoundHttpException;
        $dp = new ActiveDataProvider();
        $dp->getPagination()->pageSize = $params['pageSize'];
        $dp->query = $user->getEventCreate()->checkSubscribe()->orderBy('event.id DESC');
        return $this->renderCollection($dp);
    }

    public function actionSubscribe($user_id)
    {
        /**
         * @var $userAuth User
         */
        $userAuth = \Yii::$app->user->identity;
        if ($userAuth->id == $user_id || !\Yii::$app->request->isAjax) {
            throw new NotFoundHttpException;
        }
        $error = false;
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $subscribeLink = UserSubscriber::find()->where([
            'user_id' => $user_id,
            'subscriber_id' => $userAuth->id
        ])->one();
        if ($subscribeLink) {
            $subscribeLink->delete();
        } else {
            $subscribeLink = new UserSubscriber();
            $subscribeLink->user_id = $user_id;
            $subscribeLink->subscriber_id = $userAuth->id;
            $error = !$subscribeLink->save();
        }

        return ['error' => $error, 'message' => $subscribeLink->getErrors()];
    }

}
