<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 10.03.15
 * Time: 13:10
 */

namespace frontend\controllers;

use common\component\Controller;
use frontend\models\EventForm;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\Comment;
use yii\web\Response;

class CommentController extends Controller{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
					[
						'actions'=>['list'],
						'allow'=>true,
					],
                    [
                        'actions'=>['add-comment'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionList($event_id){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $dp                          = new ActiveDataProvider();
        $dp->query                   = Comment::find()->with('user')->where(['event_id' => $event_id])->orderBy(['id' => SORT_DESC]);
        $dp->pagination->pageSize    = 6;
        return [
            'items'      => $dp->getModels(),
            'pageCount'  => $dp->getPagination()->getPageCount(),
            'totalCount' => $dp->getTotalCount(),
            'page'       => $dp->pagination->page,
            'count'      => $dp->getCount(),
        ];
    }

    /**
     * @return array
     * Добавление комментария
     */
    public function actionAddComment(){
        if(\Yii::$app->request->isAjax){
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $model = new Comment();
            $model->user_id = \Yii::$app->user->identity->id;
            $model->event_id = $_POST['event_id'];
            $model->message = $_POST['message'];
            $model->created = time();
            if($model->save()) {
                if(isset($_POST['notify_all']) && $_POST['notify_all'] == 'true')
                    EventForm::commenatAllNotification($_POST['event_id'], $_POST['message']);
                return [
                    'item' => $model,
                    'user' => $model->user
                ];
            }
        }
    }
}