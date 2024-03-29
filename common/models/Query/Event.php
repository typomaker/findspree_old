<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 09.03.15
 * Time: 15:15
 */

namespace common\models\Query;


use common\models\EventSubscriber;
use yii\db\ActiveQuery;

class Event extends ActiveQuery
{
    /**
     * Проверяет подписку авторизованного пользователя на событие
     * @return $this
     */
    public function checkSubscribe()
    {
        if(\Yii::$app->user->isGuest)
            return $this;
        $onCondition = 'event_subscriber.event_id = event.id and event_subscriber.user_id = :user_id';
        $onParams    = ['user_id' => \Yii::$app->user->identity->id];
        $this->select('event.*, event_subscriber.user_id AS subscribe');
        $this->leftJoin(EventSubscriber::tableName(), $onCondition, $onParams);
        return $this;
    }
	public function active(){
		$this->andWhere(['status'=>\common\models\Event::STATUS_ACTIVE]);
		return $this;
	}
	public function notActive(){
		$this->andWhere(['status'=>[\common\models\Event::STATUS_BLOCKED,\common\models\Event::STATUS_DELETED,\common\models\Event::STATUS_DISABLE]]);
		return $this;
	}
}