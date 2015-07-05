<?php
/* @var $this yii\web\View */

/* @var $userAuth \common\models\User */
/* @var $userView \common\models\User */
/* @var $dataProvider \yii\data\ActiveDataProvider */

echo \common\widgets\ListView::widget([
	'dataProvider'=>$dataProvider,
	'itemOptions' => ['tag' => false],
	'options' => ['tag' => false],
	'itemView'    => function ($model, $key, $index, $widget) use ($userView) {
		return \common\widgets\Wall::widget(['model' => $model, 'userView' => $userView]);
	},
	'layout'=>'{items}'
]);