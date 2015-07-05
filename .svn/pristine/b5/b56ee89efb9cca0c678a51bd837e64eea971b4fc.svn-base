<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 22.03.2015
 * Time: 23:01
 */
?>

<div style="padding: 10px;">
    <h1 style="color: rgb(62, 104, 169);">Findspree</h1>
    В Ваше отсутсвие произошли следующие события...
    <hr>
    <div style="overflow: hidden;">
        <?php if(!empty($subscribers)): ?>
            <div style="font-size: 12px; margin-bottom: 5px;">Следующие участники подписались на Ваши события</div>
            <?php foreach($subscribers as $user): ?>
                <a title="<?= $user['username']; ?>" style="display: block; overflow: hidden; float: left;" href="<?= $user['link']; ?>">
                    <img src="<?= $message->embed($user['avatar']); ?>" />
                </a>
            <?php endforeach ?>
        <?php endif; ?>
    </div>
</div>