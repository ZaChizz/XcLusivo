<?php


namespace frontend\controllers;

use frontend\models\BookingRequests;
use Yii;
use common\models\User;
use frontend\models\Advertiser;
use frontend\models\AdvertiserImage;
use frontend\models\AdvertiserSearch;
use frontend\models\Reviews;
use frontend\models\Replys;
use frontend\models\Colors;
use frontend\models\Services;
use frontend\models\City;
use frontend\models\Country;
use frontend\models\Nationality;
use frontend\models\Bra;
use frontend\models\Chat;
use frontend\models\Message;
use frontend\models\AdvertiserMedia;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\actions\AdvertiserCalendarAction;


/**
 * AdvetiserController implements the CRUD actions for Advetiser model.
 */
class AdvertiserController extends Controller
{

	public $layout = 'advertiser';
	protected $template = array();


	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['calendar'],
						'allow' => true,
						'roles' => ['?', '@'],
					],
					[
						'actions' => [
							'advertiser-profile',
							'non-advertiser-profile',
							'review',
							'reply',
							'confirm-booking-request',
							'refuse-booking-request',
							'upload',
							'crop-image',
							'delete-image',
							'image-set-as-default',
							'calendar',
							'bookings'
						],
						'allow' => true,
						'roles' => ['Advetiser'],
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


	public function beforeAction($action)
	{

		$model = $this->loadUserModel(Yii::$app->getUser()->id);
		$model->time_session = time();
		$model->save();

		return parent::beforeAction($action);
	}


	public function actions()
	{
		return [

		];
	}

	/**
	 * Lists all Advertiser models.
	 * @return mixed
	 */
	public function actionAdvertiserProfile()
	{
		$this->template['bookLINK'] = '';
		$this->template['bookingRequest'] = '';
		$this->template['ProceedToPaymentLINK'] = '';

		$user = $this->findUserModel();

		$services = Services::loadModels();

		if (!($model = $this->findModelByUser($user->id))) {
			$model = new Advertiser();
			$model->user_id = $user->id;
			if (!$model->save()) {
					foreach ($model->errors as $error) {
						foreach ($error as $field => $msg) {
				 			\Yii::$app->session->setFlash('error', $msg);
						}
			 		}
			}
			$model->loadServices();
		} else {
			$model = $this->findModelByUser(Yii::$app->getUser()->id);
			if (isset(Yii::$app->request->post()['Advertiser']['payment_id'])) {
				$model->payment_id = Yii::$app->request->post()['Advertiser']['payment_id'];
				if ($model->save()) {
					\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return ['output' => '', 'message' => ''];
				}
			}
			if (isset(Yii::$app->request->post()['Advertiser']['offering'])) {
				$model->offering = ',' . implode(',', Yii::$app->request->post()['Advertiser']['offering']) . ',';
				if ($model->save()) {
					//$this->redirect('advertiser-profile');
					\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return ['output' => '', 'message' => ''];
				}
			}
			if (isset(Yii::$app->request->post()['Advertiser']['receiving'])) {
				$model->receiving = ',' . implode(',', Yii::$app->request->post()['Advertiser']['receiving']) . ',';
				if ($model->save()) {
					//$this->redirect('advertiser-profile');
					\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return ['output' => '', 'message' => ''];
				}
			}

			if (isset($_POST['hasEditable'])) {
				\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				if ($model->load(Yii::$app->request->post())) {
					if (isset(Yii::$app->request->post()['Advertiser']['price'])) {
						$model->price = trim($model->price, "\x00..\x1F $");
						$value = $model->price;
						if ($model->save())
							return ['output' => $value . '$', 'message' => ''];
						else
							return ['output' => '', 'message' => 'Not valid'];
					}
					if (isset(Yii::$app->request->post()['Advertiser']['age'])) {
						$model->age = trim($model->age, "\x00..\x1F y.o.");
						$value = $model->age;
						if ($model->save())
							return ['output' => $value . ' y.o.', 'message' => ''];
						else
							return ['output' => '', 'message' => $this->getErrorMessage($model->errors)];//['output' => '', 'message' => 'Not valid'];
					}
					if (isset(Yii::$app->request->post()['Advertiser']['height'])) {
						$model->height = trim($model->height, "\x00..\x1F cm");
						$value = $model->height;
						if ($model->save())
							return ['output' => $value . ' cm', 'message' => ''];
						else
							return ['output' => '', 'message' => 'Not valid'];
					}
					if (isset(Yii::$app->request->post()['Advertiser']['weight'])) {
						$model->weight = trim($model->weight, "\x00..\x1F kg");
						$value = $model->weight;
						if ($model->save())
							return ['output' => $value . ' kg', 'message' => ''];
						else
							return ['output' => '', 'message' => 'Not valid'];
					}
					if (isset(Yii::$app->request->post()['Advertiser']['hair_id'])) {
						$model->hair_id = trim($model->hair_id, "\x00..\x1F");
						$value = $model->hair_id;
						if ($model->save())
							return ['output' => $value, 'message' => ''];
						else
							return ['output' => '', 'message' => 'Not valid'];
					}
					if (isset(Yii::$app->request->post()['Advertiser']['eye_id'])) {
						$model->eye_id = trim($model->eye_id, "\x00..\x1F");
						$value = $model->eye_id;
						if ($model->save())
							return ['output' => $value, 'message' => ''];
						else
							return ['output' => '', 'message' => 'Not valid'];
					}

					if (isset(Yii::$app->request->post()['Advertiser']['skin_id'])) {
						$model->skin_id = trim($model->skin_id, "\x00..\x1F");
						$value = $model->skin_id;
						if ($model->save())
							return ['output' => $value, 'message' => ''];
						else
							return ['output' => '', 'message' => 'Not valid'];
					}
					if (isset(Yii::$app->request->post()['Advertiser']['sex_id'])) {
						$model->sex_id = intval(Yii::$app->request->post()['Advertiser']['sex_id']);
						$value = $model->sex_id;
						if ($model->save())
							return ['output' => $value, 'message' => ''];
						else
							return ['output' => '', 'message' => 'Not valid'];
					}
					if (isset(Yii::$app->request->post()['Advertiser']['cities_id'])) {
						if (is_string(Yii::$app->request->post()['Advertiser']['cities_id'])) {
								$loc = explode(',', Yii::$app->request->post()['Advertiser']['cities_id']);
								if (!empty($loc[1]))
								{
										$searchcountry = Country::find()->where(['title' => trim($loc[1])])->one();
										$country_id = $searchcountry->id;
								}
								$searchmodel = City::find()->where(['title' => trim($loc[0])]);
								if (!empty($country_id)) {
										$searchmodel->andWhere(['id_country' => $country_id])->one();
								}
								$res = $searchmodel->one();
								if (!$res) {
										return ['output' => '', 'message' => 'Not valid'];
								}
								$model->cities_id = $res->id;
								$model->country_id = $res->id_country;
						} else {
								$model->cities_id = trim($model->cities_id, "\x00..\x1F");
								$model->country_id = City::loadCountryId($model->cities_id);
						}
						$value = $model->cities_id;
						if ($model->save()) {
								return ['output' => $value, 'message' => ''];
						} else {
							$mess = '';
							foreach ($model->errors as $error) {
								foreach ($error as $field => $msg) {
						 			$mess .= $msg."\n";
								}
					 		}
							return ['output' => '', 'message' => 'Not valid. '.$mess];
						}
					}

					if (isset(Yii::$app->request->post()['Advertiser']['nationality_id'])) {
						$model->nationality_id = trim($model->nationality_id, "\x00..\x1F");
						$value = $model->nationality_id;
						if ($model->save())
							return ['output' => $value, 'message' => ''];
						else
							return ['output' => '', 'message' => 'Not valid'];
					}

					if (isset(Yii::$app->request->post()['Advertiser']['title'])) {
						$model->title = trim($model->title, "\x00..\x1F");
						$value = $model->title;
						if ($model->save())
							return ['output' => $value, 'message' => ''];
						else
							return ['output' => '', 'message' => 'Not valid'];
					}

					if (isset(Yii::$app->request->post()['Advertiser']['desc'])) {
						$model->desc = trim($model->desc, "\x00..\x1F");
						$value = $model->desc;
						if ($model->save())
							return ['output' => $value, 'message' => ''];
						else
							return ['output' => '', 'message' => 'Not valid'];
					}
					if (isset(Yii::$app->request->post()['Advertiser']['bra_id'])) {
						$model->bra_id = trim($model->bra_id, "\x00..\x1F");
						$value = $model->bra_id;
						if ($model->save())
							return ['output' => $value, 'message' => ''];
						else
							return ['output' => '', 'message' => 'Not valid'];
					}
					if (isset(Yii::$app->request->post()['Advertiser']['shoe_size'])) {
						$model->shoe_size = trim($model->shoe_size, "\x00..\x1F");
						$value = $model->shoe_size;
						if ($model->save())
							return ['output' => $value, 'message' => ''];
						else
							return ['output' => '', 'message' => 'Not valid'];
					}
					if (isset(Yii::$app->request->post()['Advertiser']['shoe_size'])) {
						$model->shoe_size = trim($model->shoe_size, "\x00..\x1F");
						$value = $model->shoe_size;
						if ($model->save())
							return ['output' => $value, 'message' => ''];
						else
							return ['output' => '', 'message' => 'Not valid'];
					}

					if (isset(Yii::$app->request->post()['Advertiser']['phone'])) {
						$user->phone = trim($model->phone, "\x00..\x1F");
						$value = $model->phone;
						if ($user->save())
							return ['output' => $value, 'message' => ''];
						else
							return ['output' => '', 'message' => 'Not valid'];
					}

					if (isset(Yii::$app->request->post()['Advertiser']['username'])) {
						$user->username = trim($model->username, "\x00..\x1F");
						$value = $model->username;
						if ($user->save())
							return ['output' => $value, 'message' => ''];
						else
							return ['output' => $value, 'message' => 'Not valid'];
					}

					if (isset(Yii::$app->request->post()['Advertiser']['silicone'])) {
						$model->silicone = trim($model->silicone, "\x00..\x1F");
						$value = $model->silicone;
						if ($model->save())
							return ['output' => $value, 'message' => ''];
						else
							return ['output' => $value, 'message' => 'Not valid'];
					}
					if (isset(Yii::$app->request->post()['Advertiser']['pause'])) {
						$model->pause = Yii::$app->request->post()['Advertiser']['pause'];
					}
					if (isset(Yii::$app->request->post()['Advertiser']['online'])) {
						if ($model->save())
							return ['output' => '', 'message' => ''];
						else
							return ['output' => '', 'message' => 'Not valid'];
					}
				}
				// else if nothing to do always return an empty JSON encoded output
				else {
					return ['output' => 'Non save', 'message' => ''];
				}
			}
		}
		$color_data = new Colors();
		$color_data->loadModels();
		$city_data = City::loadModel();
		$bra_data = Bra::loadModel();
		$nationality_data = Nationality::loadModel();

		$adv_photo = AdvertiserMedia::getPhotosFor(Yii::$app->user->getId());
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

		return $this->render('profile', [
			'model' => $model,
			'template' => $this->template,
			'color_data' => $color_data,
			'city_data' => $city_data,
			'nationality_data' => $nationality_data,
			'bra_data' => $bra_data,
			'default_photo' => $default_photo,
			'all_photos' => $all_photo
		]);
	}


	public function actionNonAdvertiserProfile($id)
	{
		$this->layout = 'nonadvertiser';

		$nadvModel = User::findOne($id);

		/* ---Chat--- */

		$chat = $this->findChatModel($nadvModel->id);
		$message = new Message();

		if (Yii::$app->request->isPost) {

			$message->chat_id = $chat->id;
			$message->user_id = Yii::$app->getUser()->id;
			$message->content = Yii::$app->request->post('content');
			$message->created_at = time();
			$message->save();
		}
		$message->content = '';
		$this->template['chat'] = Html::a(Yii::t('app', 'My messages'), '#pop-chat', ['class' => 'link-chat fancy']);
		$this->template['title'] = Yii::t('app', 'Chat to {username}', ['username' => '<a href="'.Url::to(['advertiser/non-advertiser-profile', 'id' => $chat->nadv->id]).'">'.$chat->nadv->username.'</a>']);

		/* ---End Chat---- */


		$this->template['confirmLINK'] = '';
		$this->template['refuseLINK'] = '';
		/* Template */
		if (\Yii::$app->user->can('confirmBookingRequest')) {
			$model = $this->findBookModelForNadv($id);
			if ($model && !$model->issetBookingRequest()) {
				if ($model->canConfirm())
					$this->template['confirmLINK'] = Html::a(yii::t('app', 'Confirm booking request'), '#pop-confirm', ['class' => 'btn fancy']);
				if ($model->canRefuse())
					$this->template['refuseLINK'] = Html::a(yii::t('app', 'Refuse booking'), '#pop-action', ['class' => 'btn btn-gray fancy']);

				$models = BookingRequests::loadModel2user($model->nonadvertiser_id);

				return $this->render('nonprofile', [
					'model' => $model,
					'nadv' => $nadvModel,
					'bookings' => BookingRequests::rangeModels($models),
					'template' => $this->template,
					'chat' => $chat,
					'message' => $message,
				]);
			} else {
				return $this->render('nonprofile', [
					'model' => $model,
					'nadv' => $nadvModel,
					'bookings' => false,
					'template' => $this->template,
					'chat' => $chat,
					'message' => $message,
				]);
			}
		}

		return $this->redirect(['advertiser-profile']);
	}


	public function actionReview($id)
	{
		$this->layout = false;
		$model = new Reviews();

		if ($user = $this->loadUserModel($id)) {
			if (Yii::$app->request->isPost) {
				if ($model->load(Yii::$app->request->post())) {
					$model->id_to = $id;
					$model->id_from = Yii::$app->getUser()->id;
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

			$this->redirect('advertiser-profile');
		} else
			throw new NotFoundHttpException('User with id=' . $id . ' not found');
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
		$this->template['data'] = Html::a($model->idfrom->username, '#') . ' ' . Yii::t('app', ' 12 Dec-22 Dec ');
		$this->template['label'] = Yii::t('app', 'Reply text:');
		$this->template['textarea'] = Html::activeTextarea($reply, 'title');
		$this->template['submit'] = Html::submitButton(Yii::t('app', 'Post the reply'), ['name' => 'submit-reply', 'class' => 'btn']);

		if (Yii::$app->request->isAjax)
			return $this->render('review', ['template' => $this->template]);

		$this->redirect('advertiser-profile');
	}


	public function actionConfirmBookingRequest($id)
	{

		$model = $this->findBookModel($id);
		$model->request_status = BookingRequests::STATUS_CONFIRM;
		$model->alert = BookingRequests::ALERT_CONFIRM;

		if ($model->save())
			return $this->redirect(['advertiser-profile']);
		else {
			print_r($model->getErrors());
			die;
		}
	}


	public function actionRefuseBookingRequest($id)
	{

		$model = $this->findBookModel($id);
		$model->request_status = BookingRequests::STATUS_REFUSE;
		$model->alert = BookingRequests::ALERT_REFUSE;
		if ($model->save())
			return $this->redirect(['advertiser-profile']);
		else
			throw new NotFoundHttpException('The requested page does not confirm');
	}


	public function actionIndex()
	{
		$searchModel = new AdvertiserSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}


	/**
	 * Creates a new Advertiser model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Advertiser();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}


	/**
	 * Updates an existing Advertiser model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}


	/**
	 * Deletes an existing Advertiser model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}


	/**
	 * Upload photo
	 * @param string $imgBase64
	 */
	public function actionUpload()
	{
		$post = Yii::$app->request->post();
		if (!empty($post['imgBase64'])) {
			echo AdvertiserMedia::addImage(Yii::$app->user->getId(), base64_decode(str_replace('data:image/jpeg;base64,', '', $post['imgBase64'])));
		} else {
			throw new NotFoundHttpException('The image not saved');
		}
	}


	public function actionCropImage()
	{
		$post = Yii::$app->request->post();
		if (!empty($post['cropImage']) && !empty($post['cropData'])) {
			$imageHash = pathinfo($post['cropImage'], PATHINFO_FILENAME);
			if (AdvertiserMedia::find()->where(['user_id' => Yii::$app->user->getId(), 'hash' => $imageHash])->one()) {
				echo AdvertiserMedia::saveCropImage($imageHash, base64_decode(str_replace('data:image/jpeg;base64,', '', $post['cropData'])));
				return;
			}
		}
		throw new NotFoundHttpException('The image not cropped');
	}


	public function actionDeleteImage()
	{
		$post = Yii::$app->request->post();
		if (!empty($post['hash'])) {
			$model = AdvertiserMedia::find()->where(['user_id' => Yii::$app->user->getId(), 'hash' => $post['hash']])->one();
			if ($model) {
				$model->delete();
				return;
			}
		}
		throw new NotFoundHttpException('The image not deleted');
	}

	public function actionImageSetAsDefault()
	{
		$post = Yii::$app->request->post();
		if (!empty($post['hash'])) {
			$def = AdvertiserMedia::getDefaultPhoto(Yii::$app->user->getId());
			if ($def) {
				$def->is_default = 0;
				$def->save();
			}
			$model = AdvertiserMedia::find()->where(['user_id' => Yii::$app->user->getId(), 'hash' => $post['hash']])->one();
			if ($model) {
				$model->is_default = 1;
				$model->save();
				return;
			}
		}
		throw new NotFoundHttpException('The image not changed');
	}

	public function actionBookings()
	{
		$model = $this->findModelByUser(\Yii::$app->user->getId());

		$bq = $model->getBookings();

		$bqPending = clone $bq;
		$bqPending->pending();

		$bqActive = clone $bq;
		$bqActive->active();

		$countPending = $bqPending->count();
		$countActive = $bqActive->count();

		$bookings = array(
			'pending' => array(
				'count' => $countPending,
				'content' => $countPending > 0 ? $this->renderAjax('a_booking_list', [
					'id' => 'a-pending-booking-list',
					'provider' => new \yii\data\ActiveDataProvider(['query' => $bqPending, 'pagination' => false])]) : ''
			),
			'active' => array(
				'count' => $countActive,
				'content' => $countActive > 0 ? $this->renderAjax('a_booking_list', [
				 	'id' => 'a-active-booking-list',
				 	'provider' => new \yii\data\ActiveDataProvider(['query' => $bqActive->orderBy('from_date ASC'), 'pagination' => ['pageSize' => 3]]),
				 ]) : ''
			)
		);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $bookings;
	}


	/**
	 * Finds the Advetiser model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Advertiser the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Advertiser::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}


	protected function findModelByUser($id)
	{
		if (($model = Advertiser::find()->joinWith(['advertiserScores'])->where(['user_id' => $id])->one()) !== null) {
			return $model;
		} else {
			return false;
		}
	}


	protected function findUserModel()
	{
		if (($model = User::findOne(Yii::$app->getUser()->id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}


	protected function loadUserModel($id)
	{
		if ($model = User::find()->joinWith(['params'])->where(['user.id' =>$id])->one()) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}


	protected function findBookModel($id)
	{
		if (($model = BookingRequests::findOne($id)) !== null) {
			return $model;
		} else {
			// throw new NotFoundHttpException('The requested page does not exist.');
			return false;
		}
	}

	protected function findBookModelForNadv($id)
	{
		if (($model = BookingRequests::find(['nonadvertiser_id' => $id])->andWhere(['request_status' => BookingRequests::STATUS_ACTIVE])->one()) !== null) {
			return $model;
		} else {
			// throw new NotFoundHttpException('The requested page does not exist.');
			return false;
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


	protected function findChatModel($id)
	{
		$model = Chat::findOne([
			'adv_id' => Yii::$app->user->getId(),
			'nadv_id' => $id,
		]
		);
		if ($model !== null) {
			return $model;
		}	else {
			return false; // чат не должен создаваться при заходе на страницу адва
			// $model = new Chat();
			// $model->adv_id = Yii::$app->user->getId();
			// $model->nadv_id = $id;
			// $model->created_at = time();
			// $model->updated_at = time();
			// if ($model->save())
			// 	return $model;
			// else {
			// 	return false;
			// }
		}
	}

	private function getErrorMessage($errors)
	{
		$ret = '';
		foreach ($errors as $error) {
			foreach ($error as $field => $msg) {
				$ret .= $msg;
			}
		}
		return $ret;
	}


}
