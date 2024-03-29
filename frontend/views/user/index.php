<?php
/* @var $this yii\web\View */
use common\helpers\String;
use common\models\User;
use yii\helpers\Url;

/* @var $userAuth User */
/* @var $userView User */
/* @var $eventSubscribe  \common\models\Event[] */
/* @var $eventCreate  \common\models\Event[] */
frontend\assets\User::register($this);
$isSubscribed = $userAuth ? $userView->isSubscribed($userAuth) : false;
$this->title = $userView->username;
?>
<div class="row">
	<div class="col-md-3 user-left col-md-offset-1">
		<div class="avatar-edit" style="overflow: hidden;position: relative">
			<?= \common\helpers\Html::avatar($userView, User::AVATAR_240, ['class' => 'img-responsive user-avatar center-block img-circle ']); ?>
			<?php if ($userView->isMy()): ?>
				<a href="<?= Url::to(['user/avatar-change']) ?>" title="Сменить аватар" class="avatar-edit-click"><i
						class="md md-camera-alt md-5x"></i></a>
			<?php endif ?>
		</div>
		<div class="panel panel-default">
			<div class="panel-body">
				<?php if ($userView->isOnline()): ?>
					<div class="md md-brightness-1 user-point-on pull-right" title="Онлайн"></div>
				<?php else: ?>
					<div class="md md-brightness-1 user-point-off pull-right" title="Оффлайн"></div>
				<?php endif ?>
				<h2><?= $userView->username ?></h2>
			</div>
			<?php if (!$userView->isMy()): ?>
				<?php if ($isSubscribed): ?>
					<div id="user-subscribe"
						 class="btn  btn-success btn-block"
						 data-remote="<?= Url::to(['user/subscribe', 'user_id' => $userView->id]); ?>">
						<i class="md md-group"></i> <span>ВЫ ПОДПИСАНЫ</span>
					</div>
				<?php else: ?>
					<div id="user-subscribe"
						 class="btn  btn-info  btn-block"
						 data-remote="<?= Url::to(['user/subscribe', 'user_id' => $userView->id]); ?>">
						<i class="md md-group"></i> <span>ПОДПИСАТЬСЯ</span>
					</div>
				<?php endif ?>
			<?php endif; ?>
		</div>
		<div class="list-group">
			<a id="menu-wall" href="#" class="list-group-item menu-item" data-action="wall">
				Действия
			</a>
			<a id="menu-event-subscribe" href="#" class="list-group-item menu-item" data-action="eventSubscribe">
				Пойдет на события <span
					class="badge badge-default"><?= $userView->getEventSubscribe()->count() ?></span>
			</a>
			<a id="menu-event-create" href="#" class="list-group-item menu-item" data-action="eventCreated">
				Создал события <span class="badge badge-default"><?= $userView->getEventCreate()->count() ?></span>
			</a>
			<a id="menu-signed" href="#" class="list-group-item menu-item" data-action="signed">
				Подписан <span class="badge badge-default"><?= $userView->getSigned()->count() ?></span>
			</a>
			<a id="menu-subscribers" href="#" class="list-group-item menu-item" data-action="subscribers">
				Подписчики <span class="badge badge-default"><?= $userView->getSubscribers()->count() ?></span>
			</a>
		</div>
	</div>
	<div id="content" class="col-md-7">
		<div id="act-wall" class="act" style="display: none"
			 data-remote="<?= Url::to(['/user/wall', 'id' => $userView->id]); ?>">
			<h1 class="heading">
				Действия <span class="counter"></span>
			</h1>
			<hr class="separator"/>
			<div class="body row"></div>
			<div class="text-center panel-empty  panel-next-page">
				<i class="md md-sync md-loop md-spin-reverse md-3x" style="display: none"></i>
				<i class="md md-event-note md-3x"></i>
			</div>
			<div class="footer panel-next-page"><i class="md md-more-horiz"></i></div>
		</div>
		<div id="act-event-subscribe" class=" act"
			 data-remote="<?= Url::to(['/user/events-subscribe', 'id' => $userView->id]); ?>">
			<h1 class="heading">
				Пойдет на события <span class="counter"></span>
			</h1>
			<hr class="separator"/>
			<div class="body row"></div>
			<div class="text-center panel-empty  panel-next-page">
				<i class="md md-sync md-loop md-spin-reverse md-3x" style="display: none"></i>
				<i class="md md-event-note md-3x"></i>
			</div>
			<div class="footer panel-next-page"><i class="md md-more-horiz"></i></div>
		</div>
		<div id="act-event-create" class=" act"
			 data-remote="<?= Url::to(['/user/events-created', 'id' => $userView->id]); ?>">
			<h1 class="heading">
				Создал события <span class="counter"></span>
			</h1>
			<hr class="separator"/>
			<div class="body row"></div>
			<div class="text-center panel-empty  panel-next-page">
				<i class="md md-sync md-loop md-spin-reverse md-3x" style="display: none"></i>
				<i class="md md-event-note md-3x"></i>
			</div>
			<div class="footer panel-next-page"><i class="md md-more-horiz"></i></div>
		</div>
		<div id="act-signed" class=" act" style="display: none"
			 data-remote="<?= Url::to(['/user/signed', 'id' => $userView->id]); ?>">
			<h1 class="heading">
				Подписан на пользователей <span class="counter"></span>
			</h1>
			<hr class="separator"/>
			<div class="body row">
			</div>
			<div class="text-center panel-empty  panel-next-page">
				<i class="md md-sync md-loop md-spin-reverse md-3x" style="display: none"></i>
				<i class="md md-event-note md-3x"></i>
			</div>
			<div class="footer panel-next-page"><i class="md md-more-horiz"></i></div>
		</div>
		<div id="act-subscribers" class=" act"
			 data-remote="<?= Url::to(['/user/subscribers', 'id' => $userView->id]); ?>">
			<h1 class="heading">
				Подписчики <span class="counter"></span>
			</h1>
			<hr class="separator"/>
			<div class="body row">
			</div>
			<div class="text-center panel-empty  panel-next-page">
				<i class="md md-sync md-loop md-spin-reverse md-3x" style="display: none"></i>
				<i class="md md-event-note md-3x"></i>
			</div>
			<div class="footer panel-next-page"><i class="md md-more-horiz"></i></div>
		</div>
	</div>
</div>


<script id="tpl-event-wide" type="text/html">
	<div class="user-page-item col-xs-12 col-md-12 col-md-6 col-lg-6">
		<?= $this->renderFile('@app/views/tpl/event-line.php'); ?>
	</div>
</script>
<script id="tpl-wall-event-create" type="text/html">
	<div class="user-page-item col-xs-12">
		<?= $this->renderFile('@app/views/tpl/wall-event-create.php'); ?>
	</div>
</script>
<script id="tpl-wall-event-edit" type="text/html">
	<div class="user-page-item col-xs-12">
		<?= $this->renderFile('@app/views/tpl/wall-event-edit.php'); ?>
	</div>
</script>
<script id="tpl-wall-subscribe-event" type="text/html">
	<div class="user-page-item col-xs-12">
		<?= $this->renderFile('@app/views/tpl/wall-subscribe-event.php'); ?>
	</div>
</script>
<script id="tpl-wall-subscribe-user" type="text/html">
	<div class="user-page-item col-xs-12">
		<?= $this->renderFile('@app/views/tpl/wall-subscribe-user.php'); ?>
	</div>
</script>
<script id="tpl-user" type="text/html">
	<div class="user-page-item col-xs-12 col-md-12 col-md-6 col-lg-6">
		<?= $this->renderFile('@app/views/tpl/user.php'); ?>
	</div>
</script>