<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 22.03.2015
 * Time: 1:54
 */
?>

<div>

    Доброго времени!
    Ваш адрес електронной почты был указан при регистрации на сайте <a href="http://findspree.ru">http://findspree.ru</a>!<br>
    Для активации аккаунта пройдите по ссылке: <a href="<?= \Yii::$app->urlManager->createAbsoluteUrl(['site/verificate', 'key' => $key]); ?>">Подтвердить аккаунт</a>
    <p>
        <small>Если Вы не регистрировались у нас на сайте, то просто удалите данное письмо.</small>
    </p>

</div>