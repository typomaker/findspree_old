<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 17.03.15
 * Time: 10:47
 */
namespace console\controllers;

use common\models\EventSubscriber;
use common\models\User;
use common\models\Wall;
use yii\console\Controller;

class MailController extends Controller {

    /**
     * Уведомления при подписке на человека
     */
    public function actionSubscriptionUserNotifications(){
        $date_minus_six_hours = new \DateTime();
        $date_minus_six_hours = $date_minus_six_hours->modify('-2 hours');
        $email_queue = [];
        $wall_events = Wall::find()->where('created >= '.$date_minus_six_hours->getTimestamp().' AND created <= '. time())->all();
        foreach($wall_events as $event){
            if($event->type == 2) {
                $event_data = json_decode($event->mem);
                $User = User::findOne(['id' => $event_data->to]);
                $Subscriber = User::find()->where(['id' => $event_data->from])->asArray()->one();
                if($Subscriber) {
                    $email_queue[$User->email][$event_data->from] = [
                        'subscriber' => User::find()->where(['id' => $event_data->from])->asArray()->one(),
                        'data' => $event->created,
                        'status' => $event_data->status
                    ];
                }
            }
        }

        foreach ($email_queue as $email => $recipient) {
            $subscribed = [];
            $unsubscribed = [];
            foreach($recipient as $person) {
                if ($person['status']) {
                    $subscribed[] = $person;
                } else {
                    $unsubscribed[] = $person;
                }
            }
            $messages[] = \Yii::$app->mailer->compose('user-subscribe', ['subscribed' => $subscribed, 'unsubscribed' => $unsubscribed])
                ->setFrom('noreply@findspree.ru')
                ->setTo($email)
                ->setSubject('Для Вас есть новые уведомления на сайте http://findspree.ru');
        }
        if(isset($messages) && !empty($messages))
            \Yii::$app->mailer->sendMultiple($messages);
    }

    /**
     * Уведомление при подуписке на событие
     */
    public function actionSubscriptionEventNotification()
    {
        $date_minus_two_hours = new \DateTime();
        $date_minus_two_hours = $date_minus_two_hours->modify('-2 hours');
        $email_queue = [];
        $wall_events = EventSubscriber::find()->where('created >= '.$date_minus_two_hours->getTimestamp().' AND created <= '. time())->with(['user', 'event'])->all();
        $events = [];
        foreach($wall_events as $sunscriberLink){
            $user = $sunscriberLink->user;
            $event = $sunscriberLink->event;
            $eventOwmner = $event->user;
            $events[$eventOwmner->email][] =  [
                'username' => $user->username,
                'avatar' => \Yii::getAlias('@frontend').'/web/images/users/'.$user->avatar.'/60x.jpeg',
                'link' => 'http://findspree.ru/user'.$user->id
            ];
        }

        foreach($events as $email => $ev){
            $messages[] = \Yii::$app->mailer->compose('user-event-subscribe', ['subscribers' => $ev])
                ->setFrom('noreply@findspree.ru')
                ->setTo($email)
                ->setSubject('Для Вас есть новые уведомления на сайте http://findspree.ru');
        }

        if(isset($messages) && !empty($messages))
            \Yii::$app->mailer->sendMultiple($messages);
    }
}