<?php


namespace common\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\web\View;
use common\assets\ProjectAsset;

class Flash extends Widget
{

	protected $_flashes = [];


	public function init()
	{
		parent::init();
		$session		 = \Yii::$app->session;
		$this->_flashes	 = $session->getAllFlashes();
		ProjectAsset::register($this->view);
		$this->view->registerJs('project.initFlashHandler();', View::POS_READY);
	}


	public function run()
	{
		if ($this->_flashes) {
			$content = '';
			
			foreach ($this->_flashes as $type => $data) {
				$content .= Html::tag('div', $data, ['class' => 'alert alert-' . $type, 'data-type' => $type]);
			}
			
			$content = Html::tag('div', $content, ['style' => 'display:none;']);
			return $content;
		}
	}


}
