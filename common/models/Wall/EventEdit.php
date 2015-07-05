<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 09.03.15
 * Time: 22:56
 */

namespace common\models\Wall;



use common\models\Event;
use common\models\User;

class EventEdit extends DataContainer{
    public $eventId;
    public $userId;

    public function rules()
    {
        return [
            [['eventId','userId'],'required']
        ];
    }

    public function getModel()
    {
        $user  = \Yii::$app->db->cache(function () {
            return User::findOne($this->userId);
        }, 20);
        $event = \Yii::$app->db->cache(function () {
            return Event::findOne($this->eventId);
        }, 20);
        return [
            'user'  => $user,
            'event' => $event,
        ];
    }
}