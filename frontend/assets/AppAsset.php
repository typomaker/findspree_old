<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'libs/taginput/bootstrap-tagsinput.css',
        'libs/material-design/css/material-design-iconic-font.min.css',
        'libs/growl/css/jquery.growl.css',
        'libs/socicon/socicon.css',
        'css/site.css',
    ];
    public $js = [
        'libs/masonry.pkgd.min.js',
        'libs/imagesloaded.pkgd.min.js',
//        'libs/moment.min.js',
        'libs/underscore-min.js',
        'libs/url.js',
        'libs/jquery.cookie.js',
        'libs/growl/js/jquery.growl.js',
		'js/common.js'
    ];
    public $depends = [
		'frontend\assets\TimePicker',
	];
}
