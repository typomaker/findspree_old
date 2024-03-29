<?php
/* @var $this yii\web\View */
/* @var $eventTypeList array */
\frontend\assets\EventListAsset::register($this);
$this->title = 'События';
Yii::$app->view->registerMetaTag([
    'name' => "description",
    'itemprop' => "description",
    'content' => 'Поиск интересных мероприятий на ближайшую неделю.'
]);
Yii::$app->view->registerMetaTag([
    'name' => "keywords",
    'itemprop' => 'keywords',
    'content' => 'москва,сегодня,мероприятия,события,отдых,вечеринка'
]);
?>
<div class="row">
    <div class="col-md-3">
        <div class="input-group">
            <input id="filter-date" type="text" data-initial="<?= Yii::$app->request->get('begin') ?>" value=""
                   class="form-control" placeholder="Дата события" readonly>
			<span class="input-group-btn">
				<span class="btn  trigger"><i id="filter-date-clear" class="md-clear"></i></span>
			</span>
        </div>
    </div>
    <div class="col-md-3">
        <?= \common\helpers\Html::dropDownList('type', Yii::$app->request->get('type'), \yii\helpers\ArrayHelper::getColumn($eventTypeList, 'name'), ['id' => 'search-event-type',
            'class' => 'form-control',
            'prompt' => 'Все категории'
        ]) ?>
    </div>
    <div class="col-md-3">
        <?= \common\helpers\Html::dropDownList('act', Yii::$app->request->get('act'), [
            \common\models\Event::GROUP_FINISHED => 'Прошедшие',
            \common\models\Event::GROUP_ALL => 'Все'
        ], ['id' => 'search-event-act',
            'class' => 'form-control',
            'prompt' => 'Предстоящие',
            'title' => 'Статус событий'
        ]) ?>
    </div>
    <div class="col-md-3">
        <div class="input-group">
			<span class="input-group-btn">
				<span class="btn  trigger" style="<?= !Yii::$app->request->get('search') ? 'display:none' : '' ?>"><i
                        id="filter-search-clear" class="md-clear"></i></span>
				<span class="btn"><i id="filter-date-clear" class="md-search"></i></span>
			</span>
            <input id=filter-search type="text" class="form-control" placeholder="Поиск"
                   value="<?= Yii::$app->request->get('search') ?>">
        </div>
    </div>
</div>
<br/>
<div class="row">
    <div id="events-list-empty" class="event-list-empty  text-muted"
         style="display:none; text-align: center;font-size: 20px;">
        События не найдены
    </div>
    <div id="events-container">
    </div>
</div>
<script id="tpl-event-item" data-remote="<?= \yii\helpers\Url::to(['event/index']); ?>" type="text/html">
    <div class="col-sm-6 col-xs-12 col-md-4 col-lg-3  item">
        <?= $this->renderFile('@app/views/tpl/event-box.php'); ?>
    </div>
</script>


