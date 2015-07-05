<?php
/**
 * Created by PhpStorm.
 * User: Альберт
 * Date: 05.05.2015
 * Time: 22:37
 */

namespace console\controllers;


use common\models\Tag;
use common\models\TagEvent;
use yii\console\Controller;
use yii\db\ActiveRecord;
use yii\helpers\Console;

class TagController extends Controller
{
	public function actionNormalize()
	{
		/**
		 * @var $tag Tag
		 */
		$updated = 0;
		$deleted = 0;
		$list = [];
		foreach (Tag::find()->each() as $tag) {
			$name = mb_strtolower($tag->name);
			if(isset($list[$name])){
				TagEvent::updateAll(['tag_id'=>$list[$name]],['tag_id'=>$tag->id]);
				$tag->delete();
				$deleted++;
				continue;
			}
			$list[$name]=$tag->id;
		}
		$this->stdout(Console::wrapText("- $updated updated, $deleted deleted", 10), Console::BOLD);
		$this->stdout("\n");
	}
}