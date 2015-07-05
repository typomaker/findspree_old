<?php
/**
 * Created by PhpStorm.
 * User: Альберт
 * Date: 04.05.2015
 * Time: 1:20
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class TimePicker extends AssetBundle {
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'libs/datetime-picker/css/bootstrap-datetimepicker.css',
	];
	public $js = [
		'libs/datetime-picker/js/bootstrap-datetimepicker.min.js',
		'libs/datetime-picker/js/locales/bootstrap-datetimepicker.ru.js',
	];
	public $depends = [
		'yii\bootstrap\BootstrapPluginAsset',
		'yii\web\YiiAsset',
	];
}