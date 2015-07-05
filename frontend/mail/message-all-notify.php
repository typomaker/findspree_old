<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19.03.15
 * Time: 17:56
 */

?>

<div>
    <a title="<?= $notifier->username; ?>" href="http://findspree.ru/user<?= $notifier->id; ?>">
        <img src="<?= $message->embed(\Yii::getAlias('@frontend').'/web/images/users/'.$notifier->avatar.'/60x.jpeg'); ?>" />
    </a><br>
    <b>Сообщение:</b>
    <div>
        <?= strip_tags($msg); ?>
    </div>
</div>