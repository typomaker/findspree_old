<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\Feedback */
/* @var $success boolean*/

$this->title                   = 'Обратная связь';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-form">
    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>Если вам есть что нам сказать, то заполните форму ниже:</p>
			<div class="alert alert-success <?= !$success?'hidden':''?>">
				<p>Сообщение отправлено.</p>
			</div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'title') ?>
                    <?= $form->field($model, 'body')->textarea(['rows'=>5]) ?>
                    <?= $form->field($model, 'email') ?>
                    <div style="color:#999;margin:1em 0">
                        Оставьте свой email, если желаете получить ответ на свое сообщение.
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('Готово', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

    </div>


</div>
</div>
