<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 22.02.2015
 * Time: 23:42
 */
?>
<div class="row">
    <div class="col-xs-12 col-sm-5 col-md-6 col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">Личная информация</div>
            <div class="panel-body">
                <div class="col-xs-4">
                    <img class="img-circle img-responsive" style="min-width: 80px;"
                         src="/images/user_empty.png">
                </div>
                <div class="col-xs-8">
                    <h3 class="my-user-title"><?= Yii::$app->user->identity->username; ?></h3>
                    <a href="">Настройки</a>
                </div>
                <div class="col-xs-12" style="border-top: 1px solid #f2f2f2; margin-top: 10px; padding-top: 10px;">
                    <p>г. Москва, ул. Гогена 12 кв. 173</p>
                </div>

                <button class="col-xs-4 btn btn-success">
                    Посетил: 12
                </button>
                <button class="col-xs-4 btn btn-primary">
                    Создал: 1217
                </button>
                <button class="col-xs-4 btn btn-info">
                    Рейтинг: 120
                </button>


            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Подписчики (20)</div>
            <div class="panel-body">
                <img src="../images/users/1201985170_1201735663_img79325.jpg" alt="..." class="img-circle"
                     style="max-width: 50px; margin-bottom: 5px; margin-right: 5px; cursor: pointer;">
                <img src="../images/users/1201985170_1201735663_img79325.jpg" alt="..." class="img-circle"
                     style="max-width: 50px; margin-bottom: 5px; margin-right: 5px; cursor: pointer;">
                <img src="../images/users/1201985170_1201735663_img79325.jpg" alt="..." class="img-circle"
                     style="max-width: 50px; margin-bottom: 5px; margin-right: 5px; cursor: pointer;">
                <img src="../images/users/1201985170_1201735663_img79325.jpg" alt="..." class="img-circle"
                     style="max-width: 50px; margin-bottom: 5px; margin-right: 5px; cursor: pointer;">
                <img src="../images/users/1201985170_1201735663_img79325.jpg" alt="..." class="img-circle"
                     style="max-width: 50px; margin-bottom: 5px; margin-right: 5px; cursor: pointer;">
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-7 col-md-6 col-lg-9">

        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#user_events" aria-controls="home" role="tab" data-toggle="tab">Мои мероприятия</a></li>
                <li role="presentation"><a href="#current_events" aria-controls="profile" role="tab" data-toggle="tab">Текущие мероприятия</a></li>
                <li role="presentation"><a href="#completed_events" aria-controls="messages" role="tab" data-toggle="tab">Прошедшие мероприятия</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="user_events">
                    <br>

                    <div class="row">
                        <?php foreach ($current_events as $c_event): ?>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                <div class="panel panel-default">
                                    <div class="my-event-cont">
                                        <div class="my-event-img">
                                            <a href="<?= Yii::$app->urlManager->createUrl(['event/display', 'id' => $c_event->id]); ?>"><img
                                                    style=" width: 150px;"
                                                    src="http://lurkmore.so/images/thumb/d/d3/Panda_sviborg.jpg/180px-Panda_sviborg.jpg"/></a>
                                        </div>
                                        <div class="my-event-body">
                                            <span class="my-event-title"><?= $c_event->name; ?></span>
                                            <span></span>
                                            <p class="my-event-icon">
                                                <i class="md md-work"> <span><?= \common\helpers\Time::dateNormalize($c_event->begin); ?></span></i>
                                                <br><i class="md md-equalizer"> <span>324</span></i>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="current_events">...</div>
                <div role="tabpanel" class="tab-pane fade" id="completed_events">...</div>
            </div>

        </div>
    </div>
</div>