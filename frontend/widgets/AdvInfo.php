<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 29.04.2016
 * Time: 17:01
 */


namespace frontend\widgets;

use common\models\User;
use yii\web\NotFoundHttpException;
use frontend\models\BookingRequests;
use frontend\models\Reviews;
use frontend\models\PaymentsList;


class AdvInfo extends \yii\bootstrap\Widget
{

	public $id;
	public $advertiser;
	protected $model;
	protected $bookingModel = array();
	protected $reviews;
	protected $reviews_date;


	public function init()
	{
		parent::init();
		$this->bookingModel['STATUS_ACTIVE'] = array();
		$this->bookingModel['STATUS_CONFIRM'] = array();
		$this->bookingModel['STATUS_EARLY'] = array();
	}


	public function run()
	{

		$this->findUserModel();

		$bq = $this->advertiser->getBookings();

		$bqPending = clone $bq;
		$bqPending->pending();

		$bqActive = clone $bq;
		$bqActive->active();

		$bqPast = clone $bq;
		$bqPast->past()->notStub();
//var_dump($this->loadReviewsDate()); die();
		/*
		 * DEPRECATED
		if ($this->model && $this->model->params) {
			foreach ($this->model->params->bookingRequests as $value) {
				if ($value->request_status == BookingRequests::STATUS_ACTIVE)
					$this->bookingModel['STATUS_ACTIVE'][] = $value;


				if ($value->request_status == BookingRequests::STATUS_CONFIRM)
					$this->bookingModel['STATUS_CONFIRM'][] = $value;


				if ($value->request_status == BookingRequests::STATUS_EARLY)
					$this->bookingModel['STATUS_EARLY'][] = $value;
			}
		}
		 *
		 */
		$payments = PaymentsList::findAll(['enabled_for_payout' => 1]);
		return $this->render('AdvInfo/index', [
			'model' => $this->model,
			'booking' => $this->bookingModel,
			'reviews' => $this->loadReviewsDate(),
			'payments' => $payments,
			'advPayment' => $this->advertiser->payment_id,
			'bqPending' => $bqPending,
			'bqActive' => $bqActive,
			'bqPast' => $bqPast,
			'advertiser' => $this->advertiser
		]);
	}


	protected function findUserModel()
	{
		if (($this->model = User::findOne($this->id)) !== null) {
			return true;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}


	protected function loadReviewsDate()
	{
		if (($this->reviews = Reviews::find()->where(['id_from' => $this->id])->all()) !== null) {
			foreach ($this->reviews as $value) {
				$this->reviews_date[$value->id_to] = date('j', $value->date_add) . ' ' . date('M', $value->date_add);
			}
			return $this->reviews_date;
		} else {
			return false;
		}
	}


}

?>
