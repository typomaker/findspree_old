<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 10.03.15
 * Time: 1:42
 * @var $model  \common\models\Wall
 * @var $status int
 * @var $event  \common\models\Event
 * @var $user   \common\models\User
 */
use common\helpers\Time;
use common\models\Wall\SubscribeEvent;
use yii\helpers\Url;

?>
<div class="media">
	<div class="media-left">
		<a href="<?= Url::to(['/user/index','id'=>$user->id]);?>">
			<?=$user->getAvatar(\common\models\User::AVATAR_60);?>
		</a>
	</div>
	<div class="media-body">
		<h5 class="media-heading">
			<?=$user->username;?> создал новое событие | <small><?= Time::dateNormalize($model->created);?></small></h5>
		<div class="media">
			<div class="media-left">
				<a href="<?= Url::to(['event/view','id'=>$event->id]);?>">
					<?=$event->getImage(\common\models\Event::IMAGE_THUMB_SM,['class'=>'media-object','width'=>50]);?>
				</a>
			</div>
			<div class="media-body">
				<strong	 class="media-heading"><?=$event->name;?></strong>
				<p>
					<?=\common\helpers\String::truncate($event->description);?>
				</p>
			</div>
		</div>

	</div>
</div>