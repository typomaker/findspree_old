<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

$this->title                   = 'Сброс пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password main-form">

    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>Ведите новый пароль:</p>

            <div class="panel panel-default">
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
