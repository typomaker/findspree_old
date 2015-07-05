<?php
/**
 * Created by PhpStorm.
 * User: Альберт
 * Date: 04.05.2015
 * Time: 5:20
 */

namespace common\helpers;


class Arr {
	/**
	 * Сравнивает два массива
	 * @param array $before Первый массив
	 * @param array $after Второй массив
	 * @return array
	 */
	public static function diff(array $before,array $after){
		$result = [];
		foreach ($after as $key=>$value) {
			if(!isset($before[$key])){
				$result['after'][$key]=$value;
			}elseif(is_array($before[$key]) && is_array($value)){
				if($diff = static::diff($before[$key],$value)){
					$result['before'][$key] = isset($diff['before'])?$diff['before']:[];
					$result['after'][$key] = isset($diff['after'])?$diff['after']:[];
				}
			}elseif($before[$key]!=$value){
				$result['before'][$key]=$before[$key];
				$result['after'][$key]=$value;
			}
		}
		foreach ($before as $key=>$value) {
			if(!isset($after[$key])){
				$result['before'][$key]=$value;
			}
		}

		return $result;
	}
}