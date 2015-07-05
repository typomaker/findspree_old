<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 03.03.15
 * Time: 10:35
 * @var $event \common\models\Event
 * @var $this  \yii\web\View
 */
use common\models\User;
use yii\helpers\Url;

$this->registerJsFile('/js/event-view.js', ['depends' => \frontend\assets\YMapAsset::className()]);
$this->registerCssFile('/css/event-view.css', ['depends' => \frontend\assets\AppAsset::className()]);
$date = \common\helpers\Time::toDateTime($event->begin);
$this->title = $event->name
?>

<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-6 col-lg-5">
				<div class="panel panel-default">
					<div class="event-buttons">
						<?php if ($event->isMy()): ?>
							<a href="<?= Url::to(['event/edit', 'id' => $event->id]) ?>" class="event-favorite"><i
									class="md  md-settings md-2x"></i></a>
						<?php else: ?>
							<span id="subscribe"
								  data-remote="<?= Url::to(['/event/subscribe', 'id' => $event->id]); ?>">
										<?php if (!$event->subscribe): ?>
											<span class="event-favorite"><i
													class="md md-favorite-outline md-2x"></i></span>
										<?php else: ?>
											<span class="event-favorite"><i class="md md-favorite md-2x"></i></span>
										<?php endif ?>
									</span>
						<?php endif; ?>
					</div>
					<div class="event-cover">
						<?= $event->getImage(\common\models\Event::IMAGE_MAIN, [
							'class' => 'img-responsive',
							'rel'   => 'image_src'
						]); ?>
						<?php if ($event->isCompleted()): ?>
							<div class="event-status">Завершено</div>
						<?php endif; ?>
					</div>
					<div id="map"
						 data-title='<?= $event->geo_title ?>'
						 data-description='<?= $event->geo_description ?>'
						 data-coordinates='<?= json_encode([$event->geo_longitude, $event->geo_latitude]) ?>'>
					</div>
					<div class="panel-body">
						<div id="event-info">
							<?= $this->render('/event/view-info.php', ['event' => $event]); ?>
							<hr class="separator"/>
						</div>
<span class="pull-right">
			<?= \common\widgets\Share::widget([
												  'title'       => $event->name,
												  'description' => $event->description,
												  'viewName'    => '@app/views/tpl/sharelink.php',
												  //custom view file for you links appearance
												  'url'         => \yii\helpers\Url::to([
																							'event/view',
																							'id' => $event->id
																						], true),
												  'image'       => $event->getImage(\common\models\Event::IMAGE_MAIN, [
													  'onlyLink'    => true,
													  'absoluteUrl' => true
												  ])
											  ]);; ?>
		</span>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-7">
				<div id="main-content">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 class="event-title"><?= $event->name; ?> </h3>
							<?php if (!empty($event->tags)): ?>
								<?php foreach ($event->tags as $tag): ?>
									<a href="<?= \yii\helpers\Url::to([
																		  'site/index',
																		  'act' => \common\models\Event::GROUP_ALL,
																		  'tag' => $tag->name
																	  ]) ?>" class="label label-primary tag-link"
									   title="<?= $tag->name; ?>">#<?= $tag->name; ?></a>
								<?php endforeach; ?>
								<hr class="separator"/>
							<?php endif ?>
							<p class="text-muted" id="event-description">
								<?= \common\helpers\Html::bb2html(html_entity_decode($event->description)); ?>
							</p>

							<hr class="separator"/>
							<div class="media">
								<div class="media-left">
									<a href="<?= Url::to(['user/index', 'id' => $event->user_id]); ?>">
										<?= \common\helpers\Html::avatar($event->user, User::AVATAR_60, ['class' => 'media-object img-circle']); ?>
									</a>
								</div>
								<div class="media-body">
									<h5 class="media-heading"><?= $event->user->username; ?></h5>
									Опубликовал событие <?= \common\helpers\Time::dateNormalize($event->created_at); ?>
								</div>
							</div>
						</div>

					</div>
				</div>
				<?= $this->render('/event/view-subscribers.php', ['event' => $event]); ?>

				<?= $this->render('/event/view-comments.php', ['event' => $event]); ?>
			</div>
		</div>
	</div>
</div>