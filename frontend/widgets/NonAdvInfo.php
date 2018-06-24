<?php


namespace frontend\widgets;

use common\models\User;
use yii\web\NotFoundHttpException;
use common\models\Booking;
use frontend\models\Reviews;
use common\helpers\Toolbox;


class NonAdvInfo extends \yii\bootstrap\Widget
{

	public $user;
	public $payments;

	public function init()
	{
		parent::init();

		if (!$this->user || !($this->user instanceof User) || $this->user->params) {
			throw new \yii\base\Exception('Non-advertiser User model required.');
		}
	}


	public function run()
	{
		$params = [
			'model' => $this->user,
			'isOwn' => $this->getIsOwn(),
			'payments' => $this->payments
			];

		return $this->render('NonAdvInfo/index', $params);
	}


	public function getIsOwn()
	{
		return (Toolbox::currentNonAdvertiser()) && (Toolbox::currentNonAdvertiser()->id == $this->user->id);
	}


}
