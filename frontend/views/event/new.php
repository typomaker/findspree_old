<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 22.02.15
 * Time: 3:57
 * @var  $this          \yii\web\View
 * @var  $model         \frontend\models\EventForm
 * @var  $form          \yii\bootstrap\ActiveForm
 * @var  $eventTypeList \common\models\EventType[]
 * @var  $user          \common\models\User
 */
\frontend\assets\EventCreateAsset::register($this);
$fakeEventPrice = new \common\models\EventPrice();
?>
<?php $form = \yii\bootstrap\ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $form->field($model, 'geoCoordinates', ['template' => '{input}'])->hiddenInput()->label(false); ?>
<?= $form->field($model, 'geoDescription', ['template' => '{input}'])->hiddenInput()->label(false); ?>
	<div id="form-event-new" class="row">
		<div class="item col-md-4">
			<div class="panel panel-default">
				<div class="panel-body">
					<?= $form->field($model, 'img')->label(
						'Выберите изображение',
						['class' => 'btn btn-info btn-block']
					)->fileInput(
						[
							'class'  => 'hidden',
							'accept' => 'image/*',
						]
					); ?>
                    <div id="avatar-preview-label" class="text-info" style="display:<?= $model->img?'none':'block' ?>" >
                        Допустимые расшиярения изображения: jpeg, jpg, gif, png. Размер файла не должен превышать 10 мб.
						<br/>
						Если высота изображения в двое больше чем ширина, то изображение обрежется<br/>
						Рекомендуем загружать картинки шириной минимум 300 пикселей, с не прозрачным фоном, без анимации.
                    </div>
                    <img id="avatar-preview" class="center-block img-responsive" src="<?= $model->img?>" alt="" style="display: none"/>

				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-body">
					<?= $form->field($model, 'type')->dropDownList(
						\yii\helpers\ArrayHelper::getColumn($eventTypeList, 'name')
					); ?>
					<?= $form->field($model, 'site')->textInput(['placeholder' => 'http://...']); ?>
					<?= $form->field($model, 'begin')->textInput(['placeholder' => '16.11.1992 6:30']); ?>
					<?= $form->field($model, 'end')->textInput(['placeholder' => '16.11.' . date('Y') . ' 6:30']); ?>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-body">
					<?= $form->field($model, 'geoTitle')->textInput(['placeholder' => 'Город, Улица, Дом...']); ?>
					<div id="map"></div>
				</div>
			</div>

		</div>
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-body">
					<?= $form->field($model, 'name')->textInput(['placeholder' => '...']); ?>
					<?= $form->field($model, 'description')->textarea(
						[
							'rows'            => 20,
							'placeholder'     => '...'
						]
					); ?>
					<button type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#bb-help">
						<i class="md md-help"></i>  Форматирование
					</button>
					<button type="button" id="description-preview-btn" class="btn btn-primary btn-sm pull-right">
						<i class="md md-visibility"></i> Предпросмотр
					</button>

				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-body">
					<?= $form->field($model, 'tag'); ?>
					<blockquote class="small text-muted ">
						В тегах разрешено использовать буквы латинского и русского алфавита и символ '_', теги разделяйте между собой пробелом или запятой
					</blockquote>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">

				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-body">
					<label for="">Стоимость</label>
					<div id="price-row-template"class="hidden" >
						<?= $this->render('_price-row',['form'=>$form,'key'=>'X','eventPrice'=>$fakeEventPrice,'params'=>['disabled'=>'disabled']])?>
					</div>
					<div class="price-list">
						<?php
						foreach ($model->getPrice() as $key => $eventPrice): ?>
							<?= $this->render('_price-row',['form'=>$form,'key'=>$key,'eventPrice'=>$eventPrice])?>
						<?php endforeach ?>
					</div>

					<div id = "price-add-row" class="btn btn-info btn-block"> <i class="md md-add"></i> Добавить стоимость</div>
					<br/>
					<blockquote class="small text-muted ">
						Если ваше мероприятие бесплатное, то в поле "Цена" введите "0"
					</blockquote>
				</div>
			</div>
		</div>

	</div>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<?= \yii\helpers\Html::a('Сохранить','', ['class' => 'btn btn-success btn-block','id'=>'event-save']); ?>
			</div>
		</div>
	</div>
</div>

<?php $form->end() ?>
<div id="description-preview" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Предпросмотр описания</h4>
			</div>
			<div class="modal-body" style="min-height: 300px">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="bb-help" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Форматирование описания</h4>
			</div>
			<div class="modal-body" style="min-height: 300px">
				<p class="text-muted">
					Для форматирование описания события вы можете использовать следующие теги:
				</p>
				<table class="table table-condensed">
					<thead>
					<tr>
						<td>Использование</td>
						<td>Результат</td>
					</tr>
					</thead>
					<tbody>
						<tr>
							<td><b>[b]</b>Жирный текст<b>[/b]</b></td>
							<td><strong>Жирный текст</strong></td>
						</tr>
						<tr>
							<td><b>[i]</b>курсивный<b>[/i]</b></td>
							<td><i>курсивный</i></td>
						</tr>
						<tr>
							<td><b>[u]</b>Подчеркнутый<b>[/u]</b></td>
							<td><span style="text-decoration: underline">Подчеркнутый</span></td>
						</tr>
						<tr>
							<td><b>[s]</b>Зачеркнутый<b>[/s]</b></td>
							<td><span style="text-decoration: line-through">Зачеркнутый</span></td>
						</tr>
						<tr>
							<td><b>[p]</b>Параграф<b>[/p]</b></td>
							<td><p>Параграф</p></td>
						</tr>
						<tr>
							<td><b>[em]</b>Важный<b>[/em]</b></td>
							<td><em>Важный</em></td>
						</tr>
						<tr>
							<td><b>[small]</b>Маленький<b>[/small]</b></td>
							<td><small>Маленький</small></td>
						</tr>
						<tr>
							<td><b>[center]</b>Центрированный<b>[/ceneter]</b></td>
							<td><div style="text-align: center">Центрированный</div></td>
						</tr>
						<tr>
							<td><b>[url <?= \yii\helpers\Url::to(['/'],true) ?>]</b>Ссылка<b>[/url]</b></td>
							<td><a href="<?= \yii\helpers\Url::to([''],true) ?>">Ссылка</a></td>
						</tr>
						<tr>
							<td><b>[img]</b>http://findspree.ru/images/user_empty.png<b>[/img]</b></td>
							<td><img src="http://findspree.ru/images/user_empty.png" alt=""/></td>
						</tr>
						<tr>
							<td>
								<b>[ul]</b><br/>
								&nbsp;&nbsp;&nbsp;&nbsp;<b>[li]</b>Первый элемент списка<b>[/li]</b> <br/>
								&nbsp;&nbsp;&nbsp;&nbsp;<b>[li]</b>Второй элемент списка<b>[/li]</b> <br/>
								&nbsp;&nbsp;&nbsp;&nbsp;<b>[li]</b>Третий элемент списка<b>[/li]</b> <br/>
								<b>[/ul]</b> <br/>
							</td>
							<td>
								<ul>
									<li>Первый элемент списка</li>
									<li>Второй элемент списка</li>
									<li>Третий элемент списка</li>
								</ul>
							</td>
						</tr>
						<tr>
							<td>
								<b>[ol]</b><br/>
								&nbsp;&nbsp;&nbsp;&nbsp;<b>[li]</b>Первый элемент нумерованного списка<b>[/li]</b> <br/>
								&nbsp;&nbsp;&nbsp;&nbsp;<b>[li]</b>Второй элемент нумерованного списка<b>[/li]</b> <br/>
								&nbsp;&nbsp;&nbsp;&nbsp;<b>[li]</b>Третий элемент нумерованного списка<b>[/li]</b> <br/>
								<b>[/ol]</b> <br/>
							</td>
							<td>
								<ol>
									<li>Первый элемент нумерованного списка</li>
									<li>Второй элемент нумерованного списка</li>
									<li>Третий элемент нумерованного списка</li>
								</ol>
							</td>
						</tr>
						<tr>
							<td>
								Перенос строки.<b>[/br]</b> Вторая строка <b>[/br]</b> Третья строка.
							</td>
							<td>
								Перенос строки.<br/> Первая строка <br/> вторая строка.
							</td>
						</tr>
						<tr>
							<td>
								Ссылка вида <b>https://youtu.be/66p0l6jJjYo</b>
							</td>
							<td>
								Будет преобразована в: <br/>
								<iframe width="420" height="315" class="center-block" src="https://www.youtube.com/embed/66p0l6jJjYo" frameborder="0" allowfullscreen></iframe>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->