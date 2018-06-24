<?php


namespace frontend\controllers;

use yii;
use frontend\models\BookingRequests;
use frontend\models\Reviews;
use frontend\models\Replys;
use frontend\models\PaymentsList;
use common\models\User;
use common\helpers\Toolbox;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


class NonAdvertiserController extends \yii\web\Controller
{

	public $layout = 'nonadvertiser';
	protected $template = array();


	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['non-advertiser-profile', 'review', 'reply', 'index', 'booking'],
						'allow' => true,
						'roles' => ['NON Advetiser'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}


	public function actions()
	{
		return [
			'history' => \frontend\actions\BookingHistoryAction::className(),
			'booking' => [
				'class' => \frontend\actions\AdvertiserCalendarAction::className(),
				'view' => '@frontend/views/non-advertiser/calendar',
			],
		];
	}


	public function actionIndex()
	{
		$model = Toolbox::currentNonAdvertiser();

		if (!$model) {
			throw new HttpException(403, 'Access Denied.');
		}

		return $this->render('profile', [
			'model' => $model,
		]);
	}


	public function actionNonAdvertiserProfile($id = null)
	{

		/*
		  if ($model = BookingRequests::loadModel2User(Yii::$app->getUser()->id)) {
		  $this->message(BookingRequests::checkAlert($model));
		  }
		 *
		 */
		if ($id) {
			$user = $model = $this->findModel($id);
		} else {
			$user = $model = Toolbox::currentNonAdvertiser();
		}

		if (isset($_POST['hasEditable'])) {
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


			if (isset(Yii::$app->request->post()['NonAdvertiser']['phone'])) {
				$user->phone = trim(Yii::$app->request->post()['NonAdvertiser']['phone'], "\x00..\x1F");
				$value = $user->phone;
				if ($user->save())
					return ['output' => $value, 'message' => ''];
				else
					return ['output' => '', 'message' => 'Not valid'];
			}


			// else if nothing to do always return an empty JSON encoded output
			else {
				return ['output' => 'Non save', 'message' => ''];
			}
		}
		$payments = PaymentsList::findAll(['enabled_for_payment' => 1]);

		return $this->render('profile', [
			'model' => $model,
			'user' => $user,
			'payments' => $payments,
			'isOwn' => true
		]);
	}


	public function actionReview($id)
	{
		$this->layout = false;
		$model = new Reviews();

		if ($user = $this->findModel($id)) {
			if (Yii::$app->request->isPost) {

				if ($model->load(Yii::$app->request->post())) {
					$model->id_to = $id;
					$model->id_from = Yii::$app->getUser()->id;
					$model->date_add = time();
					$model->save();
				}
			}
			$this->template['title'] = Yii::t('app', 'Write a review');
			$this->template['data'] = Html::a($user->username, '#') . ' 12 Dec-22 Dec ';
			$this->template['label'] = Yii::t('app', 'Review text:');
			$this->template['textarea'] = Html::activeTextarea($model, 'title');
			$this->template['submit'] = Html::submitButton(Yii::t('app', 'Post the review'), ['name' => 'submit-review', 'class' => 'btn']);

			if (Yii::$app->request->isAjax) {
				return $this->render('review', ['template' => $this->template]);
			}

			$this->redirect('non-advertiser-profile');
		} else {
			throw new NotFoundHttpException('User with id=' . $id . ' not found');
		}
	}


	public function actionReply($id)
	{

		$this->layout = false;
		$model = $this->findReviewsModel($id);
		$reply = new Replys();

		if (Yii::$app->request->isPost) {

			if ($reply->load(Yii::$app->request->post())) {
				$reply->id_review = $id;
				$reply->id_from = Yii::$app->getUser()->id;
				$reply->date_add = time();
				$reply->save();
			}
		}
		$this->template['title'] = Yii::t('app', 'Write a reply');
		$this->template['data'] = Html::a($model->idfrom->username, '#') . ' 12 Dec-22 Dec ';
		$this->template['label'] = Yii::t('app', 'Reply text:');
		$this->template['textarea'] = Html::activeTextarea($reply, 'title');
		$this->template['submit'] = Html::submitButton(Yii::t('app', 'Post the reply'), ['name' => 'submit-reply', 'class' => 'btn']);

		if (Yii::$app->request->isAjax)
			return $this->render('review', ['template' => $this->template]);

		$this->redirect('non-advertiser-profile');
	}


	protected function message($models)
	{
		if (!empty($models)) {
			foreach ($models as $key => $model) {
				Yii::$app->getSession()->setFlash('confirm' . $key, [
					'direction' => 'confirm booking request',
					'title' => Yii::t('app', 'Congratulations, {username}! Your booking request has been confirmed by {username2}', ['username' => $model->nonadvertiser->username, 'username2' => $model->advertiser->user->username ]),
					'text' => '&nbsp;',
				]);

				Yii::$app->getSession()->setFlash('booking' . $key, [
					'direction' => 'confirm booking request',
					'title' => Yii::t('app', 'You just confirmed booking request <br/>from {username}', ['username' => $model->advertiser->user->username]),
					'text' => 'Date: 12.09.2016, Time: 12:00 - 16:00',
				]);
				$model->alert = BookingRequests::ALERT_DONE;
				$model->save();
			}
		}
	}


	protected function findModel($id)
	{
		if (($model = User::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}


	protected static function findReviewsModel($id)
	{
		if (($model = Reviews::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}


	/*
	  protected function findUserModel()
	  {
	  if (($model = User::findOne(Yii::$app->getUser()->id)) !== null) {
	  return $model;
	  } else {
	  return false;
	  }
	  }
	 *
	 */

}
