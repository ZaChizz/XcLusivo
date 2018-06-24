<?php


namespace common\behaviors;

use yii;
use yii\base\Behavior;


class AjaxBehavior extends Behavior
{

	public $appendFlashes = true;


	/**
	 * 
	 * @param boolean $success
	 * @param mixed $params Array or string
	 */
	public function renderAjax($success, $params = [])
	{
		if (!is_array($params)) {
			$params = ['content' => (string) $params];
		}

		$params['success'] = intval((boolean) $success);

		if ($this->appendFlashes && ($flashes = $this->grabFlashes())) {
			$params['flashes'] = $flashes;
		}
		
		
		return json_encode($params, JSON_PRETTY_PRINT); //TODO: remove pretty
	}


	/**
	 * 
	 * @return array
	 */
	protected function grabFlashes()
	{
		$flashes = Yii::$app->session->getAllFlashes();
		$result	 = [];

		foreach ($flashes as $key => $message) {
			$result[] = ['type' => $key, 'message' => $message];
		}

		return $result;
	}


}
