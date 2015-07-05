<?php

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
        <style type="text/css">

        </style>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <?= $content ?>
    <?php $this->endBody() ?>
    <div style="font-size: 12px; color: #666;">
        <hr>
        На данное сообщение не нужно отвечать, оно создано автоматической системой оповещения пользователей.<br>
        Если вы получили это сообщение по ошибке, свяжитесь со службой поддержки <a href="mailto:support@findspree.ru">findspree</a><br>
        <span style="color: #333;">Findspree team &copy; 2015</span>
    </div>
    </body>
    </html>
<?php $this->endPage() ?>