<?php
/* @var $this \yii\web\View */
use common\helpers\Html;
use common\helpers\String;
use common\models\User;
$this->beginContent('@frontend/views/layouts/common.php');

?>
<script type="application/javascript">
	var App = {};
	var Helper = {
		html: {},
		string: {},
		text: {},
		bbRulesQueue:<?= json_encode(Html::$bbRulesQueue)?>
	};

	Helper.html.sizesAvatar = <?= \yii\helpers\Json::encode(User::$sizesAvatar)?>;
	Helper.html.colorsAvatar = <?= \yii\helpers\Json::encode(Html::$colorsAvatar)?>;
	Helper.string.chars = <?= \yii\helpers\Json::encode(array_merge(String::$charsEng,String::$charsRus))?>;
	App.homeUrl = "<?= Yii::$app->getHomeUrl()?>";
	App.user = {
		isGuest: <?= \yii\helpers\Json::encode(Yii::$app->user->isGuest)?>
	};
</script>
<?php
/* @var $content string */
?>
<div class="wrap">
	<?php
	\yii\bootstrap\NavBar::begin([
									 'innerContainerOptions' => ['class' => 'container'],
									 'brandLabel'            => 'Findspree',
									 'brandUrl'              => Yii::$app->homeUrl,
									 'options'               => [
										 'class' => 'navbar navbar-inverse navbar-fixed-top',
									 ],
								 ]);
	$menuItems[] = [
		'label'   => 'О сервисе',
		'url'     => '#',
		'options' => ['data-toggle' => 'modal', 'data-target' => '#hello']
	];
	$menuItems[] = ['label' => 'Обратная связь', 'url' => ['/site/feedback']];
	$menuItems[] = ['label' => 'Карта', 'url' => ['/event/map']];
	$menuItems[] = [
		'label'  => 'События',
		'url' => ['/site/index'],
	];
	$menuItems[] = ['label' => 'Добавить событие', 'url' => ['/event/edit']];
	?>

	<?php if (Yii::$app->user->isGuest) {
		$menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
		$menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
	}
	else {
		$menuItems[] = [
			'label'       => Html::avatar(Yii::$app->user->identity, 50, ['class' => 'img-circle hidden-xs']) . ' ' . \yii\helpers\Html::tag('span', Yii::$app->user->identity->username, ['class' => 'username']),
			'encode'      => false,
			'options'     => ['class' => 'user-main-avatar'],
			'linkOptions' => ['id' => 'user-main-link'],
			'items'       => [
				['label' => 'Профиль', 'url' => ['/user/index']],
				'<li role="presentation" class="divider"></li>',
				['label' => 'Выход', 'url' => ['/site/logout']],
			]
		];
	}
	echo \yii\bootstrap\Nav::widget([
										'activateParents' => true,
										'options'         => ['class' => 'navbar-nav navbar-right'],
										'items'           => $menuItems,
									]);
	\yii\bootstrap\NavBar::end(); ?>
	<div class="container page">
		<?= $content; ?>
	</div>

	<div id="hello" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
		 aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
						<h3 class="text-center">Добро пожаловать</h3>

					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-4">
								<h4 class="text-center">Что такое Findspree?</h4>

								<p>
									Мы стараемся сделать удобный сервис, с помощью которого ты больше не пропустишь ни
									одного интересного мероприятия.
								</p>
							</div>
							<div class="col-md-4">
								<h4 class="text-center">Что дает регистрация?</h4>

								<p>
									Это позволяет нам сообщать тебе о мероприятиях, которые тебе могут быть интересны.
								</p>

								<p>
									И да, наша регистрация не занимает много времени=)
								</p>
							</div>
							<div class="col-md-4">
								<h4 class="text-center">Как я могу помочь?</h4>

								<p>
									Мы в самом начале пути, и повторимся, наша цель создать удобный сервис для людей.
								</p>

								<p>
									Поэтому, если тебя посетит блестящая идея или ты найдешь ошибку, то ты всегда можешь
									поделиться с нами в разделе "Обратная связь".
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<p>
									<a href="<?= \yii\helpers\Url::to(['site/login']) ?>"
									   class="btn btn-block btn-primary">Войти</a>
								</p>
							</div>
							<div class="col-md-4">
								<p>
									<a href="<?= \yii\helpers\Url::to(['site/signup']) ?>"
									   class="btn btn-block btn-success">Зарегистрироваться</a>
								</p>
							</div>
							<div class="col-md-4">
								<p>
									<a href="<?= \yii\helpers\Url::to(['site/feedback']) ?>"
									   class="btn btn-block btn-info">Обратная
										связь</a>
								</p>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->endContent() ?>
