<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 15.03.15
 * Time: 18:28
 * @var $this \yii\base\View
 * @var $context \common\widgets\Share
 */
$context = $this->context;
use ijackua\sharelinks\ShareLinks;
use yii\helpers\Html;
Yii::$app->view->registerMetaTag([
	'name'=>"keywords",
	'content'=> $context->title
]);

Yii::$app->view->registerMetaTag([
	'property'=>"og:type",
	'content'=> 'article'
]);
Yii::$app->view->registerMetaTag([
	'property'=>"og:url",
	'content'=> \yii\helpers\Url::canonical()
]);
Yii::$app->view->registerMetaTag([
	'property'=>"og:image",
	'itemprop'=>"image primaryImageOfPage",
	'content'=> $context->image
]);
//twitter
Yii::$app->view->registerMetaTag([
	'name'=>"twitter:card",
	'content'=>'summary',
]);
Yii::$app->view->registerMetaTag([
	'name'=>"twitter:domain",
	'content'=>Yii::$app->getHomeUrl(),
]);
Yii::$app->view->registerMetaTag([
	'name'=>"twitter:title",
	'property'=>'og:title',
	'itemprop'=>'title name',
	'content'=>\common\helpers\String::truncate($context->title,140),
]);
Yii::$app->view->registerMetaTag([
	'name'=>"twitter:description",
	'property'=>"og:description",
	'itemprop'=>"description",
	'content'=> \common\helpers\String::truncate($context->description,140)
]);
Yii::$app->view->registerMetaTag([
	'name'=>"twitter:image",
	'content'=>$context->image,
]);

?>
<div class="socialShareBlock">
	<?=
	Html::a('', $context->shareUrl(ShareLinks::SOCIAL_FACEBOOK),
		['title' => 'Поделиться в Facebook','class'=>"socicon socicon-facebook"]) ?>
	<?=
	Html::a('', $context->shareUrl(ShareLinks::SOCIAL_TWITTER),
		['title' => 'Поделиться в Twitter','class'=>"socicon socicon-twitter"]) ?>
	<?=
	Html::a('<i class="icon-gplus-squared"></i>', $context->shareUrl(ShareLinks::SOCIAL_GPLUS),
		['title' => 'Поделиться в Google Plus','class'=>"socicon socicon-google"]) ?>
	<?=
	Html::a('<i class="icon-vkontakte"></i>', $context->shareUrl(ShareLinks::SOCIAL_VKONTAKTE),
		['title' => 'Поделиться в VK','class'=>"socicon socicon-vkontakte"]) ?>
</div>