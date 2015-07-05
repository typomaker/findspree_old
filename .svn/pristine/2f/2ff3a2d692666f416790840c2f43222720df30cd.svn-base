<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 10.03.15
 * Time: 10:59
 */
//print '<pre>'.print_r($event,1).'<pre>';
?>

<div class="panel panel-default">
    <div class="panel-heading">Комментарии  <?= \Yii::$app->user->isGuest ? '<br/><span style="font-size: 12px;">Зарегистрирутесь что бы иметь возможность оставлять комментарии</small>' : ''; ?></div>
    <div class="panel-body">
        <?php if(!\Yii::$app->user->isGuest): ?>
            <div class="col-xs-12 msg_cnt" contenteditable="true" id="msg_cnt" data-eid="<?= $event->id; ?>" style="font-size: 12px; padding: 5px;" placeholder="Начните вводить сообщение"></div>
            <button class="btn btn-primary" onclick="sent(this);" style="margin-top: 10px;   float: left;">Отправить</button>
                <?php if($event->user_id == Yii::$app->user->identity->id): ?>
                    <div style="float: left; margin-top: 15px; margin-left: 15px;"><input id="notify_all" type="checkbox" name="notify_all" /> Оповестить всех подписчиков</div>
                <?php endif; ?>
        <?php endif; ?>
        <div id="comments-container" class="col-xs-12" style="margin-top: 25px; font-size: 12px;"></div>
    </div>
    <div id="comments-next-page" class="panel-footer" style="text-align: center; font-size: 28px; cursor: pointer; color: #c7c7c7;"><i class="md md-more-horiz"></i></div>
</div>

<script id="comment-event-item" data-remote="<?= Yii::$app->urlManager->createUrl(['comment/list', 'event_id' => $event->id ]); ?>" type="text/html">
    <div class="media">
        <div class="media-left media-middle">
            <a href="<%= user.link.home %>">
				<%=   Helper.html.avatar(user, 30, {
				"class": "img-circle",
				style: "width:'50px'; height:'50px';",
				"title": user.username,
				"alt": user.username
				}) %>
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading"><%= user.username %> | <small><%= created %></small></h4>
            <%= message %>
        </div>
    </div>
</script>