<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 10.03.15
 * Time: 1:42
 * @var $model         \common\models\Wall
 * @var $userView      User пользователь, которому показываем
 * @var $status        int статус, подписался, отписался @see SubscribeUser::STATUS_*
 * @var $userTo        User список пользователей, на которых подписались
 * @var $userFrom      User пользователь который подписался
 */

use common\helpers\Time;
use common\models\User;
use common\models\Wall\SubscribeUser;

?>
<div class="media">
	<div class="media-left">
		<a href="<?= \yii\helpers\Url::to(['user/index', 'id' => $userFrom->id]); ?>"
		   title="<?= $userFrom->username; ?>">
			<?= $userFrom->getAvatar(User::AVATAR_60, ['class' => 'media-object']); ?>
		</a>
	</div>
	<div class="media-body">
		<h4 class="media-heading"><?= $userFrom->username; ?> |
			<small><?= Time::dateNormalize($model->created); ?></small>
		</h4>
		<?php if ($status == SubscribeUser::STATUS_SUBSCRIBE): ?>
			подписался
		<?php else: ?>
			отменил подписку
		<?php endif ?>
		на обновления пользователя
		<div class="media">
			<div class="media-left">
				<a href="<?= \yii\helpers\Url::to(['user/index', 'id' => $userTo->id]); ?>"
				   title="<?= $userTo->username; ?>">
					<?= $userTo->getAvatar(User::AVATAR_60, ['class' => 'media-object', 'width' => 50]); ?>
				</a>
			</div>
			<div class="media-body">
				<h4 class="media-heading"><?= $userTo->username; ?></h4>

			</div>
		</div>
	</div>
</div>
