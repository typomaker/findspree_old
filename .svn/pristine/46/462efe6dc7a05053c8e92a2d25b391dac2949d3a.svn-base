<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 18.03.15
 * Time: 10:29
 */
?>

<div style="padding: 10px;">
    <h1 style="color: rgb(62, 104, 169);">Findspree</h1>
    В Ваше отсутсвие произошли следующие события...
    <hr>
    <div style="overflow: hidden;">
    <?php if(!empty($subscribed)): ?>
        <div style="font-size: 12px; margin-bottom: 5px;">Следующие участники подписались на Ваши обновления</div>
        <?php foreach($subscribed as $user): ?>
            <a title="<?= $user['subscriber']['username']; ?>" style="display: block; overflow: hidden; float: left;" href="http://findspree.ru/user<?= $user['subscriber']['id']; ?>">
                <img src="<?= $message->embed(\Yii::getAlias('@frontend').'/web/images/users/'.$user['subscriber']['avatar'].'/60x.jpeg'); ?>" />
            </a>
        <?php endforeach ?>
    <?php endif; ?>
    </div>
    <div style="overflow: hidden;">
    <?php if(!empty($unsubscribed)): ?>
        <div style="font-size: 12px; margin-bottom: 5px;">Следующие участники отписались от Ваших обновлений</div>
        <?php foreach($unsubscribed as $user): ?>
            <a title="<?= $user['subscriber']['username']; ?>" style="display: block; overflow: hidden; float: left;" href="http://findspree.ru/user<?= $user['subscriber']['id']; ?>">
                <img src="<?= $message->embed(\Yii::getAlias('@frontend').'/web/images/users/'.$user['subscriber']['avatar'].'/60x.jpeg'); ?>" />
            </a>
        <?php endforeach ?>
    <?php endif; ?>
    </div>
</div>