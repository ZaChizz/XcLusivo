<?php


namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\LoginForm;
use backend\models\Pages;
use backend\models\Settings;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Advertiser;
use frontend\models\AdvertiserSearch;
use frontend\models\AdvertiserMedia;
use frontend\models\BookingRequests;
use frontend\models\Services;
use frontend\models\Chat;
use frontend\models\Message;
use frontend\models\City;
use frontend\models\Favorits;
use frontend\models\SpamReport;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;


/**
 * Site controller
 */
class SiteController extends Controller
{

	protected $template = array();


	public function beforeAction($action)
	{
		$this->enableCsrfValidation = false;
		Yii::$app->params['filter'] = 0;

		return parent::beforeAction($action);
	}


	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['logout', 'signup', 'email'],
				'rules' => [
					[
						'actions' => ['signup', 'email'],
						'allow' => true,
						'roles' => ['?'],
					],
					[
						'actions' => ['logout', 'email'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
//                    'logout' => ['post'],
				],
			],
		];
	}


	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//            ],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
			'calendar' => \frontend\actions\AdvertiserCalendarAction::className(),
		];
	}


	/**
	 * Displays custom error page
	 *
	 * @inheritdoc
	 */
	public function actionError()
	{
		return $this->render('error');
	}


	/**
	 * Displays homepage.
	 *
	 * @return mixed
	 */
	public function actionIndex()
	{

		$searchModel = new AdvertiserSearch();

		if ($searchModel->load(Yii::$app->request->get())) {
			Yii::$app->params['filter'] = $searchModel;
		}
		//$pages = false;
		$dataProvider = new ActiveDataProvider([
			'query' => $searchModel->search(Yii::$app->request->queryParams)->query->orderByScores(),
			'pagination' => array('pageSize' => AdvertiserSearch::ITEMS_PER_PAGE),
		]);

		return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
		]);
	}


	/**
	 * Logs in a user.
	 *
	 * @return mixed
	 */
	/* Old
	  public function actionLogin()
	  {
	  if (!\Yii::$app->user->isGuest) {
	  return $this->goHome();
	  }
	  $model = new LoginForm();
	  if ($model->load(Yii::$app->request->post()) && $model->login()) {
	  return $this->goBack();
	  } else
	  return $this->render('login', [
	  'model' => $model,
	  ]);
	  }
	 *
	 */


	/**
	 * Logs in a user.
	 *
	 * @return mixed
	 */
	public function actionLogin()
	{
		$serviceName = Yii::$app->getRequest()->getQueryParam('service');
		if (isset($serviceName)) {
			/** @var $eauth \nodge\eauth\ServiceBase */
			$eauth = Yii::$app->get('eauth')->getIdentity($serviceName);
			$eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
			$eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('site/login'));

			try {
				if ($eauth->authenticate()) {
					///var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes()); exit;
					$identity = User::findByEAuth($eauth);
					Yii::$app->getUser()->login($identity);

					// special redirect with closing popup window
					$eauth->redirect();
				} else {
					// close popup window and redirect to cancelUrl
					$eauth->cancel();
				}
			} catch (\nodge\eauth\ErrorException $e) {
				// save error to show it later
				Yii::$app->getSession()->setFlash('error', 'EAuthException: ' . $e->getMessage());

				// close popup window and redirect to cancelUrl
				//				$eauth->cancel();
				$eauth->redirect($eauth->getCancelUrl());
			}
		}

		$model = new LoginForm();
		if ($model->load($_POST) && $model->login()) {
			return $this->goBack();
		} else {
			return $this->render('login', array(
					'model' => $model,
			));
		}
	}


	/**
	 * Logs out the current user.
	 *
	 * @return mixed
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}


	/**
	 * Displays contact page.
	 *
	 * @return mixed
	 */
	public function actionContact()
	{
		$model = new ContactForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->sendEmail(Settings::find()->one()->admin_email)) {
				\Yii::$app->session->setFlash('success', 'Your message was sent! Thank you for contacting us. We will respond to you as soon as possible.');
			} else {
				\Yii::$app->session->setFlash('error', 'There was an error sending email.');
			}

			return $this->refresh();
		} else {
			return $this->render('contact', [
					'model' => $model,
			]);
		}
	}


	/**
	 * Displays about page.
	 *
	 * @return mixed
	 */
	public function actionAbout()
	{
		return $this->render('about');
	}


	/**
	 * Signs user up.
	 *
	 * @return mixed
	 */
	public function actionSignup()
	{

		$model = new SignupForm();
		if ($model->load(Yii::$app->request->post())) {
			if ($user = $model->signup()) {
				if (Yii::$app->getUser()->login($user)) {
					return $this->goHome();
				}
			}
		}

		return $this->render('signup', [
				'model' => $model,
		]);
	}


	/**
	 * Requests password reset.
	 *
	 * @return mixed
	 */
	public function actionRequestPasswordReset()
	{
		$model = new PasswordResetRequestForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->sendEmail()) {
				Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

				return $this->goHome();
			} else {
				Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
			}
		}

		return $this->render('requestPasswordResetToken', [
				'model' => $model,
		]);
	}


	/**
	 * Resets password.
	 *
	 * @param string $token
	 * @return mixed
	 * @throws BadRequestHttpException
	 */
	public function actionResetPassword($token)
	{
		try {
			$model = new ResetPasswordForm($token);
		} catch (InvalidParamException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}

		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
			Yii::$app->session->setFlash('success', 'New password was saved.');

			return $this->goHome();
		}

		return $this->render('resetPassword', [
				'model' => $model,
		]);
	}


	public function actionPage($id)
	{
		$model = Pages::findOne(['title' => $id, 'status' => 1]);
		if (is_null($model)) {
			throw new HttpException(404, 'Page not found');
		}
		return $this->render('page', [
				'model' => $model,
		]);
	}


	public function actionAdvertiser($id)
	{

		$this->layout = 'site';

		$model = $this->findModel($id);
		if (empty($model->user)) {
			throw new HttpException(404, 'Page not found');
		}

		/* ---Chat--- */

		$chat = $this->findChatModel($model->user->id, Yii::$app->request->post() && Yii::$app->request->post('content'));
		$message = new Message();
		if ($chat) {
			if (Yii::$app->request->isPost) {

				$message->chat_id = $chat->id;
				$message->user_id = Yii::$app->getUser()->id;
				$message->content = Yii::$app->request->post('content');
				$message->created_at = time();
				$message->save();
			}
			$message->content = '';
			// $this->template['chat'] = Html::a(Yii::t('app', 'Start chat'), '#pop-chat', ['class' => 'link-chat f-right fancy']);
			// $this->template['title'] = Yii::t('app', 'Chat to {username}', ['username' => $model->user->username]);
		}
		//  else {
		// $this->template['chat'] = '';
		// }
		$this->template['title'] = Yii::t('app', 'Chat to {username}', ['username' => $model->user->username]);
		$this->template['chat'] = Html::a(Yii::t('app', 'Start chat'), '#pop-chat', ['class' => 'link-chat f-right fancy']);

		/* ---End Chat---- */

		$this->template['bookLINK'] = '';
		$this->template['bookingRequest'] = '';
		$this->template['ProceedToPaymentLINK'] = '';

		/* Template */
		if (\Yii::$app->user->can('makeBookingRequest')) {
			if (BookingRequests::check($id)) {
				$this->template['bookLINK'] = Html::a(Yii::t('app', 'Book'), '#pop-book', ['class' => 'btn fancy btn-req']);
				$this->template['bookingRequest'] = Html::a(Yii::t('app', 'Make booking request'), ['site/calendar', 'id' => $model->id], ['class' => 'btn btn-req']);
				$this->template['ProceedToPaymentLINK'] = Html::a(Yii::t('app', 'Proceed to Payment'), '#pop-book_req', ['class' => 'btn fancy btn-req']);
			} else {
				$this->template['bookLINK'] = Html::a(Yii::t('app', 'Book'), '#pop-book', ['class' => 'btn fancy btn-req']);
				$this->template['bookingRequest'] = Html::a(Yii::t('app', 'Book'), ['site/calendar', 'id' => $model->id], ['class' => 'btn btn-req']);
			}
		}

		$adv_photo = AdvertiserMedia::getPhotosFor($model->user_id);
		$default_photo = '';
		$all_photo = array();
		foreach ($adv_photo as $photo) {
			$photo_data = array(
				'hash' => $photo->hash,
				'org_url' => AdvertiserMedia::getUrl($photo->hash),
				'big_url' => AdvertiserMedia::getUrl($photo->hash, AdvertiserMedia::PREFIX_BIG_THUMB),
				'small_url' => AdvertiserMedia::getUrl($photo->hash, AdvertiserMedia::PREFIX_SMALL_THUMB)
			);
			$all_photo[] = $photo_data;
			if ($photo->is_default) {
				$default_photo = $photo_data;
			}
		}


		return $this->render('advertiser/profile', [
				'model' => $model,
				'template' => $this->template,
				'chat' => $chat,
				'message' => $message,
				'default_photo' => $default_photo,
				'all_photos' => $all_photo
		]);
	}


	public function actionChat($id, $messagesOnly = false)
	{
		$this->layout = 'site';
		$model = Chat::findOne($id);
		if ($model && ($model->adv_id == Yii::$app->getUser()->id || $model->nadv_id == Yii::$app->getUser()->id)) {
			return $this->renderAjax('chats/chatpopup', ['model' => $model, 'messagesOnly' => $messagesOnly, 'user' => $model->adv_id == Yii::$app->getUser()->id ? $model->nadv : $model->adv]);
		} else {
			return Yii::t('app', 'Chat not found ' . Yii::$app->getUser()->id);
		}
	}


	public function actionChatList($id, $offs)
	{
		$models = Chat::getChatListFor($id, $offs);
		return $this->renderAjax('chats/chatlist', ['models' => $models]);
	}


	public function actionChatSendMessage($id)
	{
		if (Yii::$app->request->isAjax) {
			$model = Chat::findOne($id);
			if ($model && ($model->adv_id == Yii::$app->getUser()->id || $model->nadv_id == Yii::$app->getUser()->id) && trim(Yii::$app->request->post('content')) != '') {
				$message = new Message();
				$message->chat_id = $model->id;
				$message->user_id = Yii::$app->getUser()->id;
				$message->content = trim(Yii::$app->request->post('content'));
				$message->created_at = time();
				$message->save();

				$model->updated_at = time();
				$model->save();
			}
			return $this->renderAjax('chats/chatpopupform', ['model' => $model]);
		}
		$this->redirect('/non-advertiser/non-advertiser-profile');
	}


	public function actionChatNewMessages()
	{
		$chats = Message::getNewMessagesFor(Yii::$app->getUser()->id);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$chatsWithNewMessages = [];
		if (count($chats) > 0) {
			foreach ($chats as $chat) {
				$chatsWithNewMessages[] = $chat->chat_id;
			}
		}
		return $chatsWithNewMessages;
	}


		public function actionChangeFavorit()
		{
				$adv_id = intval(Yii::$app->request->post('adv'));
				$user_id = Yii::$app->getUser()->id;
				$model = Favorits::find()->where(['user_id' => $user_id])->andWhere(['advertiser_id' => $adv_id])->one();
				if ($model) {
					echo 'del';
					$model->delete();
				} else {
					echo 'add';
					$model = new Favorits();
					$model->user_id = $user_id;
					$model->advertiser_id = $adv_id;
					if (!$model->save()) {
						$ret = '';
						foreach ($model->errors as $error) {
							foreach ($error as $field => $msg) {
								$ret .= $msg;
							}
						}
						echo $ret;
					}
				}
		}


	public function actionReportSpam()
	{
		if (Yii::$app->request->isPost) {
			$report = new SpamReport();
			if ($report) {
				$request = Yii::$app->request;
				$model = $this->findModel($request->post('advId'));
				if ($model) {
					$report->sender_id = Yii::$app->getUser()->id;
					$report->on_whom = $model->user_id;
					$report->text = $request->post('report');
					$report->type = 1;
					$report->created_at = time();
					if ($report->save()) {
						Yii::$app->mail->compose()
							->setFrom('xclusivo@mail.ru')
							->setTo('xclusivo@mail.ru')
							->setSubject('Report spam')
							->setTextBody('New report spam received')
							->send();
					}
					return;
				}
			}
		}
		throw new NotFoundHttpException('Report does not save.');
	}


	public function actionEmail()
	{
		$toEmail = Yii::$app->request->post('toEmail', false);
		$subject = Yii::$app->request->post('subject', false);
		$msg = Yii::$app->request->post('msg', false);
		if ($toEmail && $subject && $msg) {
			Yii::$app->mail->compose()
				->setFrom('xclusivo@mail.ru')
				->setTo($toEmail)
				->setSubject($subject)
				->setTextBody($msg)
				->send();
			\Yii::$app->session->setFlash('success', 'Message succssfully sent');
		}
		return $this->render('email');
	}


	public function actionMakeBookingRequest($id)
	{
		$this->layout = 'site';

		$model = new BookingRequests();

		$model->advertiser_id = $id;
		$model->nonadvertiser_id = Yii::$app->getUser()->id;
		$model->request_status = 1;
		$model->pay_with = 1;
		$model->secure_booking = 1;
		$model->from_date = '25 Dec 2015';
		$model->to_date = '25 Dec 2015';

		if ($model->save())
			return $this->redirect(['advertiser', 'id' => $id]);
		else
			throw new NotFoundHttpException('Request not create');
	}


	public function actionCity($city)
	{
		\Yii::$app->response->format = 'json';
		//  $res = array_map(function($val) { return $val['title']; }, City::findByName($city));
		$res = [];
		$models = City::findByName($city);
		foreach ($models as $model) {
			$res[] = $model->title . ', ' . $model->country->title;
		}
		return $res;
		// return array('Oslo', 'Kharkiv', 'London');
	}


	protected function findModel($id)
	{
		$model = Advertiser::find()
			->where(['advertiser.id' => $id])
			->joinWith(['user', 'advertiserScores'])
			->andWhere(['user.status' => \common\models\User::STATUS_ACTIVE])
			->one();

		if ($model) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}


	protected function findChatModel($id, $createIfNotExists = false)
	{
		$model = Chat::findOne([
				'adv_id' => $id,
				'nadv_id' => Yii::$app->user->getId(),
				]
		);
		if ($model !== null) {
			return $model;
		} elseif ($createIfNotExists) {
			$model = new Chat();
			$model->adv_id = $id;
			$model->nadv_id = Yii::$app->user->getId();
			$model->created_at = time();
			$model->updated_at = time();
			if ($model->save()) {
				return $model;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}


}
