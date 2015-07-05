<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 15.03.15
 * Time: 7:49
 */

namespace common\widgets;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ListView extends \yii\widgets\ListView {
	public function run()
	{
		if ($this->showOnEmpty || $this->dataProvider->getCount() > 0) {
			$content = preg_replace_callback("/{\\w+}/", function ($matches) {
				$content = $this->renderSection($matches[0]);

				return $content === false ? $matches[0] : $content;
			}, $this->layout);
		} else {
			$content = $this->renderEmpty();
		}
		$tag = ArrayHelper::remove($this->options, 'tag', 'div');
		if($tag!==false){
			echo Html::tag($tag, $content, $this->options);
		}else{
			echo $content;
		}
	}
}