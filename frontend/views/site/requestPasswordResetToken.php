<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

$this->title                   = 'Сброс пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset main-form">
    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
            <h1><?= Html::encode($this->title) ?></h1>
            <p>Введите ваш email. Ссылка на страницу сброса пароля отправится на указанный email</p>
            <?php  if(Yii::$app->session->hasFlash('error')):?>
                <div class="alert alert-danger">
                    <?= Yii::$app->session->getFlash('error');?>
                </div>
            <?php endif;?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                    <?= $form->field($model, 'email') ?>
                    <div class="form-group">
                        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
