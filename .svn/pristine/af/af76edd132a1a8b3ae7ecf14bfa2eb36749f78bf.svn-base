<?php
/**
 * Created by PhpStorm.
 * User: Альберт
 * Date: 04.06.2015
 * Time: 23:56
 * @var $event \common\models\Event
 * @var $this  \yii\web\View
 */
use common\helpers\String;
$subscribeCount = $event->getSubscribers()->count();
?>

		<span title="Категория"><i class="md  md-label"></i> <?= $event->type->name; ?></span><br/>
		<span title="Адрес"><i class="md  md-place"></i> <?= $event->geo_description; ?></span><br/>
		<?php if ($event->site): ?>
			<span title="Сайт"> <i class="md-assignment"></i> <a href="<?= $event->site ?>" target="_blank"
																 title="<?= $event->site ?>"><?= parse_url($event->site, PHP_URL_HOST) ?></a>
					</span><br/>
		<?php endif ?>
		<span title="Дата начала"><i
				class="md md-alarm-on"></i>  <?= \common\helpers\Time::dateNormalize($event->begin); ?>
			<?php if ($com1 = \common\helpers\Time::period($event->begin)): ?>
				<small class="text-muted">( До начала <?= $com1; ?>)</small>
			<?php endif; ?></span>
		<br/>
		<?php if ($event->end): ?>
			<span title="Общая продолжительность">
					<i class="md md-alarm"></i>
				<?= \common\helpers\Time::period([
													 $event->begin,
													 $event->end
												 ], \common\helpers\Time::PERIOD_TIME_PASSED) ?>
				</span>
			<br/>
			<span title="Дата завершения">
					<i class="md md-alarm-off"></i>
				<?= \common\helpers\Time::dateNormalize($event->end); ?>
				<?php if (!$com1 && $com2 = \common\helpers\Time::period($event->end)): ?>
					<small class="text-muted">( До завершения <?= $com2; ?>)</small>
				<?php endif; ?>

			</span>
			<br/>
		<?php endif ?>
		<span title="Количество просмотров события"><i
				class="md md-remove-red-eye"></i>  <?= String::declension($event->getShows()->count(), [
				'просмотр',
				'просмотра',
				'просмотров'
			]); ?></span>
		<br/>
		<?php if ($subscribeCount): ?>
			<i class="md md-people"></i> <?= String::declension($subscribeCount, [
				'оценил',
				'оценили',
				'оценило'
			]); ?>
		<?php endif ?>
		<?php if ($event->priceList): ?>
			<hr class="separator"/>
			<span title="Цены"> <i class="md-account-balance-wallet"></i> Цены</span>
			<?php foreach ($event->priceList as $eventPrice): ?>
				<div>
					<i class="md md-chevron-right"></i> <span
						class=" text-info"><?= $eventPrice->cost ? String::price($eventPrice->cost) . ' руб.' : 'Бесплатно'; ?></span>
					<?php if ($eventPrice->description): ?>
						- <span class="text-muted"><?= $eventPrice->description ?></span>
					<?php endif ?>
				</div>
			<?php endforeach ?>
		<?php endif ?>
