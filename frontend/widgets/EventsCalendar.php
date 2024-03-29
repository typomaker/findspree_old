<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 02.03.15
 * Time: 13:36
 */

namespace frontend\widgets;

use common\models\Event;

class EventsCalendar extends \yii\bootstrap\Widget
{
	public function init()
	{
		parent::init();
	}

	public function run()
	{
		$nearest     = Event::getNearest(7);
		$dates_array = [];
		$weekdays    = [
			1 => 'пн.',
			2 => 'вт.',
			3 => 'ср.',
			4 => 'чт.',
			5 => 'пт.',
			6 => 'сб.',
			7 => 'вс.'

		];
		$current_date = new \DateTime(date('Y-m-d'));
		for ($i = 0; $i < 7; ++$i) {
			if ($i != 0) $current_date->modify('+1 day');
			$dates_array[] = [
				'date'       => $current_date->format('Y-m-d'),
				'day'       => $current_date->format('j'),
				'weekday'   => $current_date->format('N'),
				'timestamp' => $current_date->getTimestamp()
			];
		}
		echo '<ul class="event-calendar">';
		echo '<li class="event-calendar-all" title="Все события"><i class="md md-apps"></i></li>';
		foreach ($dates_array as $date) {
			$class = ($date['weekday'] == 6 || $date['weekday'] == 7) ? 'weekend' : '';
			if (!isset($nearest[$date['date']])) {
				$class .= ' disabled';
			}
			echo '<li class="calendar-item ' . $class . '" data-date="' . $date['timestamp'] . '" ><a href="#"><span>' . $date['day'] . '</span><small>' . $weekdays[$date['weekday']] . '</small></a></li>';
		}
		echo '</ul>';
	}
}
