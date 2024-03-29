<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 09.03.15
 * Time: 23:05
 */

namespace common\models\Wall;


use common\models\Wall;
use common\models\WallPost;
use yii\base\Model;

abstract class DataContainer extends Model
{
	private static $_classReference = [
		1 => 'common\models\Wall\SubscribeEvent',
		2 => 'common\models\Wall\SubscribeUser',
		3 => 'common\models\Wall\EventCreate',
		4 => 'common\models\Wall\EventEdit',
	];
	public function getType(){
		$class= self::className();

		if(($k = array_search($class,self::$_classReference))===false){
			throw new \ErrorException('Недопустимый класс');
		}
		return $k;
	}
    abstract public function getModel();
    public function findWall(WallPost $wallPost){

    }
	public static function convert($type,$data)
	{
		if ($data instanceof static)
			return $data;
		if (is_string($data)) {
			$data = json_decode($data, 1);
		}
		if (!isset(self::$_classReference[$type])){
			throw new \ErrorException('Недопустимый класс');
		}
		$class = self::$_classReference[$type];
		unset($data['class']);
		return new $class($data);
	}

	public function __toString()
	{
		return json_encode($this->toArray());
	}
}