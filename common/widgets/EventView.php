<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 22.02.15
 * Time: 2:46
 */

namespace common\widgets;


use yii\bootstrap\Widget;

class EventView extends Widget {
	public $model;
	public $user;
	public $descriptionLength=20;
    public function run(){
		return $this->render('eventView/vertical',['event'=>$this->model,'user'=>$this->user]);
    }

}