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


class AdvertiserCalendarAction extends Action
{

	public $viewDefault = '@frontend/views/advertiser/calendar';
	public $viewForClient = '@frontend/views/advertiser/calendar_na';
	public $viewPublic = '@frontend/views/advertiser/calendar_guest';


	public function run($id)
	{
		$model = Advertiser::find()->with('user')->andWhere(['id' => $id])->one();

		if (!$model) {
			throw new NotFoundHttpException();
		}

		if (!\Yii::$app->user->can('nonAdvetiserProfile') && \Yii::$app->user->getId() != $model->user_id) {
			throw new NotFoundHttpException();
		}

		Yii::$app->params['filter'] = $searchModel = new \frontend\models\AdvertiserSearch();

		if (!($current = Toolbox::currentUser())) {
			$view = $this->viewPublic;
			$this->controller->layout = 'site';
		} else {
			$view = (Toolbox::currentNonAdvertiser()) ? $this->viewForClient : $this->viewDefault;
			$this->controller->layout = (Toolbox::currentAdvertiser() && Toolbox::currentAdvertiser()->id == $model->id) ? 'advertiser' : 'site';
		}
		return $this->controller->render($view, ['model' => $model, 'current' => $current]);
	}


}
