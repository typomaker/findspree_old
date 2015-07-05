<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 11.03.15
 * Time: 23:47
 * @var $event \common\models\Event
 * @var $user  \common\models\User
 * @var $this  \yii\web\View
 * @var $context  \common\widgets\EventView
 */
$context = $this->context;
use yii\helpers\Url;

?>

<div class="event-item">
	<div class="event-img">
		<a href="<?= Url::to([
			'/event/view',
			'id' => $event->id
		]); ?>"><?= $event->getImage(\common\models\Event::IMAGE_MAIN, ['class' => 'img-responsive']); ?></a>
	</div>
	<div class="event-body">
		<a href="<?= Url::to(['/user/index', 'id' => $event->user->id]); ?>">
			<?= \common\helpers\Html::avatar($event->user,50,[
				'alt' => $event->user->username,
				'class'=>'media-object img-circle owner-img'
			]);?>
		</a>

		<div class="event-title"><?= $event->name; ?></div>
		<div class="event-description"><?= \common\helpers\String::truncate($event->description, $context->descriptionLength); ?></div>
		<div class="event-date"><?= \common\helpers\Time::dateNormalize($event->begin); ?></div>
		<div class="event-control">
			<?php if ($user): ?>
				<i class="md <% if(subscribe){%> md-add-circle<% }else{ %>md-add-circle-outline <%} %> event-control-subscribe "
				   data-remote="<%=link.subscribe%>"
				   title="<% if(subscribe){%> Отменить подписку<% }else{ %>Подписаться<%} %>"></i>
			<?php endif ?>
			<a href="<?= Url::to(['/event/view', 'id' => $event->id]); ?>" title="Подробнее"><i
					class="md md-menu event-control-view"></i></a>
		</div>
	</div>
</div>