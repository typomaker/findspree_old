<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 14.03.15
 * Time: 23:46
 */

namespace common\models\Wall;


use common\models\User;

class SubscribeUser extends DataContainer
{
	const STATUS_SUBSCRIBE=1;
	const STATUS_UNSUBSCRIBE=0;
	/**
	 * @var int ид пользователя который подписывается
	 */
	public $from;
	/**
	 * @var int ид пользователя, на которого подписываемся
	 */
	public $to;
	public $status=1;
	public function rules()
	{
		return [
			[['from','to','status'],'required']
		];
	}

    public function getModel(){
        $userTo   = \Yii::$app->db->cache(function () {
            return User::findOne($this->to);
        }, 20);
        $userFrom = \Yii::$app->db->cache(function () {
            return User::findOne($this->from);
        }, 20);
        return [
            'userTo'   => $userTo,
            'userFrom' => $userFrom,
        ];
    }
}