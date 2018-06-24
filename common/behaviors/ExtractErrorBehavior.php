<?php


namespace common\behaviors;

use yii;
use yii\base\Behavior;
use yii\base\Exception;


class ExtractErrorBehavior extends Behavior
{


	public function attach($owner)
	{
		if (!($owner instanceof yii\base\Model)) {
			throw new Exception('Behavior owner must be an instance of yii\base\Model.');
		}
		
		parent::attach($owner);
	}


	public function getFirstErrorMessage()
	{
		$errors = $this->owner->errors;

		if ($errors) {
			$temp	 = array_values($errors)[0];
			$temp	 = array_values($temp)[0];
			return $temp;
		} else {
			return false;
		}
	}


}
