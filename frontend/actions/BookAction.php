<?php


namespace frontend\actions;

use Yii;
use yii\base\Action;
use yii\web\Request;
use yii\web\Response;
use common\models\User;
use frontend\models\Advertiser;
use common\models\Booking;


class BookAction extends Action
{


	public function behaviors()
	{
		return [
			\common\behaviors\AjaxBehavior::className(),
		];
	}


	/**
	 * 
	 * @param int $id Advertiser ID
	 * @param int $cid Client (non-advertiser) user ID
	 * @return string
	 */
	public function run($id, $cid)
	{
//		$model = Advertiser::find()->andWhere(['id' => $id])->one();

		if (!Yii::$app->request->isPost || !Yii::$app->request->isAjax) {
			throw new \yii\web\HttpException(400, 'Invalid request');
		}


		$model = new Booking();
		$model->capturePost();
		$model->advertiser_id = intval($id);
		$model->user_id = intval($cid);
		$model->status = Booking::STATUS_PENDING;


		if ($model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('booking', 'Booking successful, please wait for confirmation.'));
			return $this->renderAjax(true);
		} else {
			Yii::$app->session->setFlash('error', $model->getFirstErrorMessage());
			return $this->renderAjax(false, 'OK');
		}
	}


}
