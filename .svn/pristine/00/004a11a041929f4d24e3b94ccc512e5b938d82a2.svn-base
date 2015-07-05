<?php

use yii\helpers\Html;
use yii\web\View;

/** @var $this View */
/** @var $widget \frontend\widgets\EAuth */
/** @var $id string */
/** @var $services stdClass[] See EAuth::getServices() */
/** @var $action string */
/** @var $popup bool */
/** @var $assetBundle string Alias to AssetBundle */

Yii::createObject(array('class' => $assetBundle))->register($this);

// Open the authorization dilalog in popup window.
if ($popup) {
	$options = array();
	foreach ($services as $name => $service) {
		$options[$service->id] = $service->jsArguments;
	}
	$this->registerJs('$("#' . $id . '").eauth(' . json_encode($options) . ');');
}

?>
<div class="eauth" id="<?php echo $id; ?>">
	<div class="eauth-list row">
		<?php
		foreach ($services as $name => $service) {
			echo '<div class="eauth-service eauth-service-id-' . $service->id . ' col-xs-4 text-center">';
			echo Html::a('', array($action, 'service' => $name), array(
				'class' => $widget->getCssClass($service),
				'data-eauth-service' => $service->id,
			));
			echo '</div>';
		}
		?>
	</div>
</div>