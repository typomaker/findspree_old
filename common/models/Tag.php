<?php

namespace common\models;

use common\helpers\String;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tag_event".
 * @property integer $id
 * @property string  $name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $popularity
 * @property string  $key
 */
class Tag extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'tag';
	}

	/**
	 * Приивязывает теги к элементам
	 * @param Event| $obj  Связывает данные модели в БД с тегом, зависит от класса переданной модели
	 * @param        array [string]  $tags Массив с тегами,
	 * @return int
	 * @throws \Exception
	 * @throws \yii\db\Exception
	 */
	public static function bind($obj, array $tags)
	{
		/**
		 * @var \common\models\Tag[] $existsTag
		 */
		$tagsS = static::filter($tags);
		$tags=[];
		foreach ($tagsS as $tag) {
			$tags[mb_strtolower($tag)]=$tag;
		}

		if (empty($tags)) return false;
		$existsTag = static::find()->where(['name' => array_values($tags)])->all();
		if ($obj instanceof Event) {// если тэг привязываем к событию(в будущем возможно теги будем привязывать к другим сущностям)
			$updatedTag = [];
			$rows = [];

			//сначала записываем существующие теги
			foreach ($existsTag as $ex) {
				$updatedTag[] = $ex->id;
				unset($tags[mb_strtolower($ex->name)]);
				$rows[] = [$ex->id, $obj->id];
			}
			foreach ($tags as $tag) {
				$tagModel = new static([
										'name' => $tag,
									]);
				$tagModel->insert();
				if ($tagModel->id) {
					$rows[] = [$tagModel->id, $obj->id,];
				}
			}
			if (!empty($updatedTag)) Yii::$app->db->createCommand('UPDATE tag SET popularity=popularity+1 WHERE id IN (' . implode(',', $updatedTag) . ')')
												  ->execute();
			return Yii::$app->db->createCommand()->batchInsert(TagEvent::tableName(), [
				'tag_id',
				'event_id'
			], $rows)->execute();
		}
	}

	/**
	 * Имя тега преобразует в ключ
	 * @param $value
	 * @return string
	 */
	public static function toKey($value)
	{
		$n = mb_strtolower(preg_replace('#[^a-zа-яё0-9]#iu', '', $value));
		return $n;
	}



	public static function filter(array $tags = [])
	{
		return array_filter($tags, function ($item) {
			return preg_match('/^[0-9a-zа-яё_\\-.]{2,80}$/iu', $item);
		});
	}

	/**
	 *  Отвязываем теги от элемента
	 * @param       $obj
	 * @param array $keys
	 * @return bool
	 * @throws \yii\db\Exception
	 */
	public static function unbind($obj, array $tags)
	{
		/**
		 * @var \common\models\Tag[] $existsTag
		 */
		$tags = static::filter($tags);
		$existsTag = [];
		if ($tags) $existsTag = static::find()->where(['name' => $tags])->asArray()->all();
		if ($obj instanceof Event) {
			$cond = ['event_id' => $obj->id];
			foreach ($existsTag as $ex) {
				$cond['tag_id'][] = $ex['id'];
			}
			if ($existsTag) Yii::$app->db->createCommand('UPDATE tag SET popularity=popularity-1 WHERE id IN (' . implode(',', ArrayHelper::getColumn($existsTag, 'id')) . ') and popularity>0')
										 ->execute();
			TagEvent::deleteAll($cond);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
//        return [
//            'id' => 'Tag Event ID',
//            'id' => 'Tag ID',
//            'id' => 'Event ID',
//        ];
	}
}
