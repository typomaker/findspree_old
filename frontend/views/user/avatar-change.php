<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 05.03.15
 * Time: 22:36
 * @var $this   \yii\web\View
 * @var $user   \common\models\User
 * @var $avatar \frontend\models\AvatarForm
 */
\frontend\assets\JCrop::register($this);
$appAssetName = \frontend\assets\AppAsset::className();
$this->registerJsFile('/js/avatar-change.js', ['depends' => [$appAssetName]]);
$this->registerCssFile('/css/avatar-change.css', ['depends' => [$appAssetName]]);
?>
<?php $form = \yii\bootstrap\ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','enableAjaxValidation'=>true]]) ?>
<?= $form->field($avatar, 'x', ['template' => '{input}'])->hiddenInput(); ?>
<?= $form->field($avatar, 'y', ['template' => '{input}'])->hiddenInput(); ?>
<?= $form->field($avatar, 'x2', ['template' => '{input}'])->hiddenInput(); ?>
<?= $form->field($avatar, 'y2', ['template' => '{input}'])->hiddenInput(); ?>
<?= $form->field($avatar, 'w', ['template' => '{input}'])->hiddenInput(); ?>
<?= $form->field($avatar, 'h', ['template' => '{input}'])->hiddenInput(); ?>
<?= $form->field($avatar, 'oH', ['template' => '{input}'])->hiddenInput(); ?>
<?= $form->field($avatar, 'oW', ['template' => '{input}'])->hiddenInput(); ?>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div id="avatar-change-container" class="panel-body">
                    <?= $form->field($avatar, 'img',['template'=>"{input}\n{hint}\n{error}"])->fileInput([
                        'class' => 'hidden',
                        'accept' => 'image/*',
                    ]) ?>
                    <label id="avatar-change-loader" for="avatarform-img">
                        <i class="md-image md-5x"></i><br/>
                        <div>Выберите изображение <br/> Допустимые расширения jpeg, jpeg, gif</div>
                    </label>

                    <div id="avatar-change-cropper">
                        <img id="avatar-change-img" class="img-responsive"/>
                        <hr/>
                        <button id="avatar-change-confirm" class="btn btn-success">Готово</button>
                        <div id="avatar-change-cancel" class="btn btn-danger">Отмена</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $form->end() ?>