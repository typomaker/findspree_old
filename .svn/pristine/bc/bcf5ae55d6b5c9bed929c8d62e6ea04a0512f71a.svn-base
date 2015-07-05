<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 17.03.15
 * Time: 23:20
 */

namespace console\controllers;


use common\helpers\Time;
use common\models\LogMain;
use common\models\Session;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Работа с данными статистики
 * Class GarbageController
 * @package console\controllers
 */
class WatcherController extends Controller
{
	/**
	 * иформация о логах
	 * @return int
	 */
	public function actionIndex()
	{

	}

	/**
	 * Удаление старыъ записей (сессии, логов)
	 */
	public function actionGarbageCollector()
	{
		$logMain = LogMain::deleteAll(['<=', 'created', time() - Time::SEC_TO_MONTH]);
		$session = Session::deleteAll(['<=', 'expire', time() - \Yii::$app->session->getTimeout()]);
		$this->stdout('- ' . $this->ansiFormat(LogMain::tableName(), Console::FG_YELLOW));
		$this->stdout(' ');
		$this->stdout(Console::wrapText("удалено $logMain записей", 10), Console::BOLD);
		$this->stdout("\n");
		$this->stdout('- ' . $this->ansiFormat(Session::tableName(), Console::FG_YELLOW));
		$this->stdout(' ');
		$this->stdout(Console::wrapText("удалено $session записей", 10), Console::BOLD);
		$this->stdout("\n");
	}
}