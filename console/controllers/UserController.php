<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 17.03.15
 * Time: 23:41
 */

namespace console\controllers;


use common\models\User;
use yii\console\Controller;
use yii\helpers\Console;

class UserController extends Controller
{
	/**
	 * Снимаем онлайн у тех, у кого за последнее время активность == 0
	 */
	public function actionRefreshOnline()
	{
		$oldTime = time() - \Yii::$app->params['onlineLength'];
		$userUpdated = User::updateAll(['<=', 'updated', $oldTime]);
		$this->stdout(Console::wrapText("- $userUpdated отправлено в оффлайн", 10), Console::BOLD);
		$this->stdout("\n");
	}
}