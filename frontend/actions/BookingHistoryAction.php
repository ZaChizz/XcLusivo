<?php


namespace frontend\actions;

use Yii;
use yii\base\Action;
use yii\web\Request;
use yii\web\Response;
use common\models\User;
use frontend\models\Advertiser;
use common\models\Booking;


class BookingHistoryAction extends Action
{

	public $view = '@app/views/booking/history';

	public function behaviors()
	{
		return [
//			\common\behaviors\AjaxBehavior::className(),
		];
	}


	public function run()
	{
		$params = [];
		return $this->controller->render($this->view, $params);
	}


}
