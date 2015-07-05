<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 09.03.15
 * Time: 15:58
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class YMapAsset extends AssetBundle{
    public $js=[
        'http://api-maps.yandex.ru/2.1/?lang=ru_RU'
    ];
    public $depends=[
        'frontend\assets\AppAsset',
    ];
}