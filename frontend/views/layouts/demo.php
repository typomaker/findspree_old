<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */
$this->beginContent('@frontend/views/layouts/common.php');
?>
<div class="wrap">
    <div class="container-fluid">
        <?= Alert::widget() ?>
        <div class="row user-top-panel">
            <div class="col-xs-5 col-lg-1">
                <img src="./images/timati4.jpg" class="img-circle user-img" width="80"/>
            </div>
            <div class="col-xs-7 col-lg-10">
                <div class="user-nick">@Timati_team</div>
                <div class="user-name"><h1>Тимати ужасный</h1></div>
                <div class="pnl-btname subscribers">
                    Подписчиков: 1217
                </div>
                <div class="pnl-btname rating">
                    Рейтинг: 120
                </div>
                <div class="pnl-btname visits">
                    Посетил: 12
                </div>
            </div>
            <div class="col-xs-12">
                <?= \yii\widgets\Menu::widget([
                    'options' => [
                        'class' => 'top_usermenu',
                    ],
                    'itemOptions' => [

                    ],
                    'encodeLabels' => false,
                    'items' => [
                        ['label' => '<i class="md md-event-available"></i> Мероприятия', 'url' => ['site/index']],
                        ['label' => '<i class="md md-beenhere"></i> Приглашения', 'url' => ['site/login']],
                        ['label' => 'Фотоотчёты', 'url' => ['site/signup']],
                    ]
                ]);
                ?>
            </div>
        </div>
        <div class="site-index">
            <div class="body-content">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container-fluid">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<?php $this->endContent()?>
