<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 05.03.15
 * Time: 15:50
 */

namespace common\helpers;


class Time
{
	const SEC_TO_YEAR        = 31556926;
	const SEC_TO_MONTH       = 2629744;
	const SEC_TO_WEEK        = 604800;
	const SEC_TO_DAY         = 86400;
	const SEC_TO_HOUR        = 3600;
	const SEC_TO_MINUTE      = 60;
	const PERIOD_TIME_PASSED = 1;
	const PERIOD_TIME_LEFT   = 2;

	static public $monthsComp = [
		1  => 'Янв',
		2  => 'Фев',
		3  => 'Мар',
		4  => 'Апр',
		5  => 'Мая',
		6  => 'Июн',
		7  => 'Июл',
		8  => 'Авг',
		9  => 'Сен',
		10 => 'Окт',
		11 => 'Ноя',
		12 => 'Дек'
	];
	static public $declension = [
		'y' => ['год', 'года', 'лет'],
		'm' => ['месяц', 'месяца', 'месяцев'],
		'd' => ['день', 'дня', 'дней'],
		'h' => ['час', 'часа', 'часов'],
		'i' => ['минута', 'минуты', 'минут'],
		's' => ['секунда', 'секунды', 'секунд'],
	];

	/**
	 * @param $value
	 * @return \DateTime
	 */
	public static function toDateTime($value)
	{
		if ($value instanceof \DateTime) {
			return $value;
		}
		if (is_numeric($value)) {
			$date = new \DateTime();
			$date->setTimestamp($value);
		}
		else {
			$date = new \DateTime($value);
		}
		return $date;
	}

	public static function dateNormalize($date, $timestamp = false)
	{
		$date = self::toDateTime($date);
		$date = explode(".", $date->format("d.m.Y H:i"));
		return $date[0] . '&nbsp;' . self::$monthsComp[(int)$date[1]] . '&nbsp;' . $date[2];
	}

	public static function period($date, $mode = self::PERIOD_TIME_LEFT)
	{
		if (!is_array($date)) {
			$date = [$date, new \DateTime()];
		}
		$start = self::toDateTime($date[0]);
		$end = self::toDateTime($date[1]);
		$diff = $start->diff($end);
		if ($mode == self::PERIOD_TIME_PASSED && $diff->invert) {
			return null;
		}
		elseif ($mode == self::PERIOD_TIME_LEFT && !$diff->invert) {
			return null;
		}
		if ($diff->y) {
			return String::declension($diff->y, self::$declension['y']);
		}
		elseif ($diff->m) {
			return String::declension($diff->m, self::$declension['m']);
		}
		elseif ($diff->d) {
			return String::declension($diff->d, self::$declension['d']);
		}
		elseif ($diff->h) {
			return String::declension($diff->h, self::$declension['h']);
		}
		elseif ($diff->i) {
			return String::declension($diff->i, self::$declension['i']);
		}
		return null;
	}
}