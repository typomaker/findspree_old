<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 09.03.15
 * Time: 16:43
 * @var $event \common\models\Event
 * @var $this  \yii\web\View
 */
use common\helpers\String;

?>
<div class="panel panel-default">
	<div class="panel-body">
		<h3 class="event-title"><?= $event->name; ?> </h3>
		<hr>
		<p class="text-muted" id="event-description">
			<?= \common\helpers\Html::bb2html(html_entity_decode($event->description)); ?>
		</p>
		<hr/>

		<?php if (!empty($event->tags)): ?>
			<?php foreach ($event->tags as $tag): ?>
				<a href="<?= \yii\helpers\Url::to(['site/index','act'=>\common\models\Event::GROUP_ALL,'tag'=>$tag->name])?>" class="label label-primary tag-link" title="<?= $tag->name; ?>">#<?= $tag->name; ?></a>
			<?php endforeach; ?>
			<hr/>
		<?php endif ?>
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