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


class NonAdvertiserBookingManageAction extends Action
{

	public $viewFile = '_manage_nonadv';


	public function run($id)
	{
		$booking = Booking::find()
			->with(['user', 'advertiser'])
			->andWhere(['id' => $id, 'status' => Booking::STATUS_PENDING])
			->one();

		if (!$booking) {
			throw new NotFoundHttpException();
		}

		if ($booking->isExpired) {
			throw new \yii\web\HttpException(403, 'Booking expired.');
		}		
		
		$nonAdv = Toolbox::currentNonAdvertiser();

		if (!$nonAdv || $nonAdv->id != $booking->user_id) {
			throw new \yii\web\HttpException(403, 'Access Denied.');
		}

		//Disable cancelling if booking approved
		if ($booking->status == Booking::STATUS_APPROVED) {
			throw new \yii\web\HttpException(403, 'Booking already approved.');
		}
		

		if (Yii::$app->request->isPost) {
			if (!isset($_POST['value'])) {
				throw new \yii\web\HttpException(400, 'Bad Request.');
			}

			$value = intval($_POST['value']);

			if (!in_array($value, [0])) {
				throw new \yii\web\HttpException(400, 'Bad Request.');
			}

			$result = [
				'value' => $value,
			];

				$booking->cancel();
				$result['success'] = true;
				$result['message'] = Yii::t('app', 'Booking cancelled.');

			echo \yii\helpers\Json::encode($result);
			Yii::$app->end();
		}

		return $this->controller->renderAjax($this->viewFile, ['model' => $booking]);
	}


}
