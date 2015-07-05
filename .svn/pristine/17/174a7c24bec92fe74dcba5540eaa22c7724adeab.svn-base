<?php
/**
 * Created by PhpStorm.
 * User: Альберт
 * Date: 02.05.2015
 * Time: 0:01
 * @var \common\models\EventPrice  $eventPrice
 * @var int                        $key
 * @var    \yii\widgets\ActiveForm $form
 * @var    array $params
 */
$containerIdCost = 'eventprice-container-cost-' . $key;
$containerIdDescription = 'eventprice-container-description-' . $key;
$inputIdCost = "eventprice-cost-$key";
$inputIdDescription = "eventprice-description-$key";
$params = isset($params)?$params:[]
?>
<div class="price-row">
	<div class="row">
		<div class="col-md-3">
			<?= $form->field($eventPrice, 'cost', [
				'options'   => [
					'id'    => $containerIdCost,
					'class' => 'price-container'
				],
				'selectors' => [
					'container' => '#' . $containerIdCost,
					'input'     => '#' . $inputIdCost
				]
			])->label(false)->textInput(array_merge($params,[
				'id'          => $inputIdCost,
				'name'        => "EventPrice[$key][cost]",
				'placeholder' => 'Цена',
			])); ?>
		</div>
		<div class="col-md-8">
			<?= $form->field($eventPrice, 'description', [
				'options'   => [
					'id'    => $containerIdDescription,
					'class' => 'price-container'
				],
				'selectors' => [
					'container' => '#' . $containerIdDescription,
					'input'     => '#' . $inputIdDescription,
				]
			])->label(false)->textInput(array_merge($params,[
											'id'          => $inputIdDescription,
											'name'        => "EventPrice[$key][description]",
											'placeholder' => 'Примечание'
										])); ?>
		</div>
		<div class="col-md-1 text-center">
			<i class="md md-2x md-clear price-add-row text-muted no-select"
			   style="cursor: pointer"></i>
		</div>
	</div>
	<hr class="separator visible-xs"/>
</div>
