<?php


namespace frontend\controllers;

use Yii;
use common\models\User;
use frontend\models\Advertiser;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\actions\AdvertiserEventFeedAction;
use frontend\actions\BookAction;


class BookingController extends Controller
{


	public function behaviors()
	{
		return [
			'access' => [
				'class'	 => \yii\filters\AccessControl::className(),
				'rules'	 => [
					[
						'allow'	 => true,
						'actions' => ['feed'],
						'roles'	 => ['?', '@'],
					],
					[
						'allow'	 => true,
						'actions' => ['book', 'stub', 'history', 'manage', 'cancel'],
						'roles'	 => ['@'],
					],
					/*
					[
						'allow'	 => true,
						'actions' => ['manage'],
						'roles'	 => ['Advertiser'],
					],
					 * 
					 */
					
				],
			],
		];
	}


	public function actions()
	{
		return [
			'feed' => AdvertiserEventFeedAction::className(),
			'book' => BookAction::className(),
			'stub' => \frontend\actions\StubAction::className(),
			'manage' => \frontend\actions\AdvertiserBookingManageAction::className(),
			'cancel' => \frontend\actions\NonAdvertiserBookingManageAction::className(),
		];
	}
	
}
