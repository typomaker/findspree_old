<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title                   = 'Вход';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login main-form">
    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>Для авторизации заполните следующие поля:</p>
            <?php  if(Yii::$app->session->hasFlash('verification')):?>
            <div class="alert alert-info">

                <?= Yii::$app->session->getFlash('verification');?>
            </div>
            <?php endif;?>
            <?php  if(Yii::$app->session->hasFlash('success')):?>
                <div class="alert alert-success">

                    <?= Yii::$app->session->getFlash('success');?>
                </div>
            <?php endif;?>
            <?php  if(Yii::$app->session->hasFlash('error')):?>
                <div class="alert alert-danger">
                    <?= Yii::$app->session->getFlash('error');?>
                </div>
            <?php endif;?>
            <div class="panel panel-default">
                <div class="panel-body">
					<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                    <?= $form->field($model, 'username') ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    <div style="color:#999;margin:1em 0">
                        Если вы забыли свой пароль, <?= Html::a('нажмите здесь', ['site/request-password-reset']) ?>.
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
					<hr class="separator row"/>
					<?php echo \frontend\widgets\EAuth::widget(array('action' => 'site/login','assetBundle'=>'frontend\assets\EAuth')); ?>
				</div>
            </div>
        </div>

    </div>
</div>
