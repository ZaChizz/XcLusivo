<?php


namespace frontend\actions;

use Yii;
use yii\base\Action;
use yii\web\Request;
use yii\web\Response;
use common\models\User;
use frontend\models\Advertiser;
use yii\web\NotFoundHttpException;
use common\helpers\Toolbox;
use common\models\Booking;


class AdvertiserBookingManageAction extends Action
{

	public $viewFile = '_manage_adv';


	public function run($id)
	{
		$booking = Booking::find()
			->with(['user', 'advertiser'])
			->andWhere(['id' => $id])
			->andWhere(['or', ['status' => Booking::STATUS_PENDING], ['status' => Booking::STATUS_STUB]])
			->one();

		if (!$booking) {
			throw new NotFoundHttpException();
		}

		if ($booking->isExpired) {
			throw new \yii\web\HttpException(403, 'Booking expired.');
		}
		
		$adv = Toolbox::currentAdvertiser();

		if (!$adv || $adv->id != $booking->advertiser_id) {
			throw new \yii\web\HttpException(403, 'Access Denied.');
		}


		if (Yii::$app->request->isPost) {
			if ($booking->status == Booking::STATUS_STUB) {
				$booking->delete();
				$result['success'] = true;
				$result['message'] = Yii::t('booking', 'Disabled range removed.');
			} else {

				if (!isset($_POST['value'])) {
					throw new \yii\web\HttpException(400, 'Bad Request.');
				}


				$value = intval($_POST['value']);

				if (!in_array($value, [0, 1])) {
					throw new \yii\web\HttpException(400, 'Bad Request.');
				}

				$result = [
					'value' => $value,
				];

				if ($value) {
					//Confirm
					$booking->approve();
					$result['success'] = true;
					$result['message'] = Yii::t('booking', 'Booking confirmed.');
				} else {
					//Cancel
					$booking->decline();
					$result['success'] = true;
					$result['message'] = Yii::t('booking', 'Booking rejected.');
				}
			}

			echo \yii\helpers\Json::encode($result);
			Yii::$app->end();
		}

		return $this->controller->renderAjax($this->viewFile, ['model' => $booking]);
	}


}
