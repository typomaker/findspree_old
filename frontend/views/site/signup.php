<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Новый пользователь';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-form site-signup">
    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>Для регистрации заполните следующие поля</p>

            <div class="panel panel-default">
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'form-signup',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                    ]); ?>
                    <?= $form->field($model, 'username') ?>
                    <?= $form->field($model, 'email') ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <div class="form-group">
                        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-offset-4 col-md-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1 text-center">
            <small class="text-muted">После регистрации на сайте требуется активация аккаунта.<br>
            Письмо с описанием процедуры активации будет отправлено на Ваш email адрес.</small>
        </div>
    </div>
</div>
