<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 18.03.15
 * Time: 21:27
 */
use common\helpers\String;
use common\models\User;
use yii\helpers\Url;

/* @var $userAuth User */
/* @var $userView User */
$isSubscribed = $userAuth ? $userView->isSubscribed($userAuth) : false;

?>
<div class="panel panel-default user-view-head hidden-xs" style="min-height: 200px">
	<div class="user-view-avatar">
		<?= $userView->getAvatar(User::AVATAR_240, ['class' => 'img-responsive user-avatar']); ?>
		<div id="user-view-edit-avatar">
			<?php if ($userView->isAuth()): ?>
				<a href="<?= Url::to(['user/avatar-change']); ?>">Изменить</a>
			<?php endif ?>
		</div>
	</div>
	<div class="user-view-main-info">
		<div class="pull-right">
			<?php if ($userView->isOnline()): ?>
				<div class="md md-brightness-1 user-point-on" title="Онлайн"></div>
			<?php else: ?>
				<div class="md md-brightness-1 user-point-off" title="Оффлайн"></div>
			<?php endif ?>
		</div>
		<h2><?= $userView->username; ?></h2>
		<p>
         <span title="Дата регистрации"><i class="md md-assignment-ind"></i> <?= \common\helpers\Time::dateNormalize($userView->created_at); ?></span>
		</p>
		<hr class="separator"/>

		<div>
			<div class="row">
				<div class="col-xs-6 text-center text-muted">
					<div class="user-view-counter"><?= $c = $userView->getSubscribers()->count(); ?></div>
					<div class="user-view-counter-title small"><?= String::declension($c, [
							'подписчик',
							'подписчка',
							'подписчиков'
						], '{text}'); ?></div>
				</div>
				<div class="col-xs-6 text-center text-muted">
					<div class="user-view-counter"><?= $c = $userView->getEventSubscribe()->count(); ?></div>
					<div class="user-view-counter-title small"><?= String::declension($c, [
							'событие',
							'события',
							'событий'
						], '{text}'); ?></div>
				</div>
			</div>
		</div>
		<hr class="separator"/>
		<div class="user-control">
			<?php if (!$userView->isMy()): ?>
				<?php if ($isSubscribed): ?>
					<div id="user-subscribe"
						 class="btn btn-xs btn-success"
						 data-remote="<?= Url::to(['user/subscribe', 'user_id' => $userView->id]); ?>">
						<i class="md md-group"></i> <span>ВЫ ПОДПИСАНЫ</span>
					</div>
				<?php else: ?>
					<div id="user-subscribe"
						 class="btn btn-xs btn-info"
						 data-remote="<?= Url::to(['user/subscribe', 'user_id' => $userView->id]); ?>">
						<i class="md md-group"></i> <span>ПОДПИСАТЬСЯ</span>
					</div>
				<?php endif ?>

			<?php endif; ?>
		</div>
	</div>
</div>
<div class="panel panel-default visible-xs">
	<div class="panel-body">
		<div class="media ">
			<div class="media-left">
				<a href="#">
					<?= $userView->getAvatar(User::AVATAR_120, ['class' => 'media-object']); ?>
				</a>
			</div>
			<div class="media-body">
				<h4 class="media-heading"><?= $userView->username; ?></h4>

				<div class="row">
					<div class="col-xs-3 text-center text-muted">
						<div class="user-view-counter-xs"><?= $c = $userView->getSubscribers()->count(); ?></div>
						<div class="user-view-counter-title-xs small"><?= String::declension($c, [
								'подписчик',
								'подписчка',
								'подписчиков'
							], '{text}'); ?></div>
					</div>
					<div class="col-xs-3 text-center text-muted">
						<div class="user-view-counter-xs"><?= $c = $userView->getEventSubscribe()->count(); ?></div>
						<div class="user-view-counter-title-xs small"><?= String::declension($c, [
								'событие',
								'события',
								'событий'
							], '{text}'); ?></div>
					</div>
					<div class="col-xs-3 text-center text-muted">
						<div class="user-view-counter-xs"><?= $c = $userView->getEventSubscribe()->count(); ?></div>
						<div class="user-view-counter-title-xs small"><?= String::declension($c, [
								'событие',
								'события',
								'событий'
							], '{text}'); ?></div>
					</div>
					<div class="col-xs-3 text-center text-muted">
						<div class="user-view-counter-xs"><?= $c = $userView->getEventSubscribe()->count(); ?></div>
						<div class="user-view-counter-title-xs small"><?= String::declension($c, [
								'событие',
								'события',
								'событий'
							], '{text}'); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-default visible-xs">
	<div class="panel-body">

	</div>
</div>