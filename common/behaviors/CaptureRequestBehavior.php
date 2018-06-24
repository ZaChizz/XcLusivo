<?php


namespace common\behaviors;

use yii;
use yii\base\Behavior;
use yii\base\Exception;


class CaptureRequestBehavior extends Behavior
{


	public function attach($owner)
	{
		if (!($owner instanceof yii\base\Model)) {
			throw new Exception('Behavior owner must be an instance of yii\base\Model.');
		}
		
		parent::attach($owner);
	}


	public function capturePost($safeOnly = true)
	{
		$className = \yii\helpers\StringHelper::basename(get_class($this->owner));
		$this->owner->setAttributes(Yii::$app->request->post($className, []), $safeOnly);
	}


}
