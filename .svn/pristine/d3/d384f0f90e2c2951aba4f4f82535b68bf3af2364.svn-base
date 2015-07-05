<?php
/**
 * Created by PhpStorm.
 * User: Альберт
 * Date: 07.05.2015
 * Time: 1:38
 */

namespace frontend\widgets;


class EAuth extends \nodge\eauth\Widget{
	static $cssClassMap = [
		'vkontakte'=>'socicon-vkontakte',
		'facebook'=>'socicon-facebook',
		'google_oauth'=>'socicon-google',
	];
	/**
	 * Executes the widget.
	 * This method is called by {@link CBaseController::endWidget}.
	 */
	public function run()
	{
		echo $this->render('eAuth/widget', array(
			'id' => $this->getId(),
			'services' => $this->services,
			'action' => $this->action,
			'popup' => $this->popup,
			'assetBundle' => $this->assetBundle,
			'widget' => $this,
		));
	}
	public function getCssClass($service){
		$result = 'eauth-service-link ';
		if(isset(static::$cssClassMap[$service->id])){
			$result.=' socicon '.static::$cssClassMap[$service->id];
		}
		return $result;
	}
}