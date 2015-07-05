<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 22.02.15
 * Time: 3:09
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class EventListAsset  extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/event-list.js'
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}