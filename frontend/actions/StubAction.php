<?php


namespace frontend\actions;

use Yii;
use yii\base\Action;
use yii\web\Request;
use yii\web\Response;
use common\models\User;
use frontend\models\Advertiser;
use common\models\Booking;


class StubAction extends Action
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
	 * @return string
	 */
	public function run($id)
	{
		if (!Yii::$app->request->isPost || !Yii::$app->request->isAjax) {
			throw new \yii\web\HttpException(400, 'Invalid request');
		}

		$adv = Advertiser::find()->andWhere(['id' => $id])->one();
		
		if (!$adv) {
			throw new \yii\web\NotFoundHttpException();
		}


		$model = new Booking();
		$model->capturePost();
		$model->advertiser_id = intval($id);
		$model->status = Booking::STATUS_STUB;


		if ($model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('booking', 'Time range disabled.'));
			return $this->renderAjax(true);
		} else {
			Yii::$app->session->setFlash('error', $model->getFirstErrorMessage());
			return $this->renderAjax(false, 'OK');
		}
	}


}
