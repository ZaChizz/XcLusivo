<?php


namespace frontend\actions;

use Yii;
use yii\base\Action;
use yii\web\Request;
use yii\web\Response;
use common\models\User;
use common\models\Booking;
use frontend\models\Advertiser;
use yii\web\NotFoundHttpException;
use common\helpers\Toolbox;
use common\helpers\Calendar;
use yii\db\ActiveQuery;
use yii\helpers\Html;


class AdvertiserEventFeedAction extends Action
{


	public function run($id, $start, $end)
	{
		$model = Advertiser::find()->with('user')->andWhere(['id' => $id])->one();

		if (!$model) {
			throw new NotFoundHttpException('Page Not Found');
		}

		$client = Toolbox::currentNonAdvertiser();
		$tsStart = Toolbox::ensureTimestamp($start);
		$tsEnd = Toolbox::ensureTimestamp($end);
		$result = [];

		if ($tsStart < time()) {
			$result[] = Calendar::generateDisabledRange($tsStart, ($tsEnd > time()) ? time() : $tsEnd);
		}

		if (Toolbox::currentNonAdvertiser()) {
			$query = Booking::find()->nonAdvertiserCalendar(Toolbox::currentNonAdvertiser()->id, $model->id);
		} else {
			$query = $model->getBookings();
		}

		$query->andWhere('(from_date BETWEEN :tsStart AND :tsEnd) OR (to_date BETWEEN :tsStart AND :tsEnd)', [':tsStart' => $tsStart, ':tsEnd' => $tsEnd]);

		if (Toolbox::currentAdvertiser() && $model->id == Toolbox::currentAdvertiser()->id) {
			$result = array_merge($result, $this->processOwner($query));
		} elseif (Toolbox::currentNonAdvertiser()) {
			$result = array_merge($result, $this->processClient($query));
		} else {
			$result = array_merge($result, $this->processGuest($query));
		}

// TESTING, EXPERIMENTS
		/*
		  $test	 = time();
		  $test = date('Y-m-d').' 18:00:00';
		  $test = Toolbox::ensureTimestamp($test)+60*60*24;
		  $h		 = 60 * 60;

		  for ($i = 0; $i < 3; $i++) {
		  $start		 = $test + $h * $i;
		  $end		 = $test + $h * ($i + 1);
		  $result[]	 = [
		  'title'		 => 'event' . $i,
		  'start'		 => Toolbox::sysFormatDateTime($start, 'T'),
		  'end'		 => Toolbox::sysFormatDateTime($end, 'T'),
		  'editable'	 => false,
		  ];
		  }
		 * 
		 */
// --------------------


		echo json_encode($result, JSON_PRETTY_PRINT);
		//$finder = Booking::find(); //Later..

		return false; //$this->controller->render($this->view, ['model' => $model]);
	}


	private function processGuest(ActiveQuery $query)
	{
		$bookings = $query->with(['user', 'advertiser'])->all();
		$result = [];

		foreach ($bookings as $b) {
			$borders = Calendar::generateEventBorders($b->from_date, $b->to_date);
			$borders[Calendar::BORDER_BEFORE]['id'] = $b->feedId . Calendar::BORDER_BEFORE;
			$borders[Calendar::BORDER_AFTER]['id'] = $b->feedId . Calendar::BORDER_AFTER;
			$result[] = $borders[Calendar::BORDER_BEFORE];

			$result[] = [
				'id' => $b->feedId,
				'title' => '',
				'start' => Toolbox::sysFormatDateTime($b->from_date, 'T'),
				'end' => Toolbox::sysFormatDateTime($b->to_date, 'T'),
				'editable' => false,
				'rendering' => 'background',
				'backgroundColor' => Calendar::eventBgColorDisabled(),
				'borderColor' => Calendar::eventBgColorDisabled(),
			];

			$result[] = $borders[Calendar::BORDER_AFTER];
		}

		return $result;
	}


	private function processOwner(ActiveQuery $query)
	{
		$bookings = $query->with(['user', 'advertiser'])->all();
		$result = [];


		foreach ($bookings as $b) {
			$borders = Calendar::generateEventBorders($b->from_date, $b->to_date);
			$borders[Calendar::BORDER_BEFORE]['id'] = $b->feedId . Calendar::BORDER_BEFORE;
			$borders[Calendar::BORDER_AFTER]['id'] = $b->feedId . Calendar::BORDER_AFTER;


			if ($b->status == Booking::STATUS_STUB) {
				$event = Calendar::stubEvent($b);
			} else {
				$event = [
//				'title' => Html::a($b->user->username, Toolbox::userPublicUrl($b->user), ['target' => '_blank']),
					'id' => $b->feedId,
					'title' => $b->user->username,
					'start' => Toolbox::sysFormatDateTime($b->from_date, 'T'),
					'end' => Toolbox::sysFormatDateTime($b->to_date, 'T'),
					'editable' => false,
					'className' => 'js-user-view fc-user-view ' . $b->statusClasses,
					'backgroundColor' => ($b->status == Booking::STATUS_APPROVED) ? Calendar::eventBgColorAccepted() : Calendar::eventBgColorPending(),
					'attributes' => $b->attributes,
				];

				$event['user_url'] = Toolbox::userPublicUrl($b->user);

				if (!$b->isExpired) {
					$event['manage_url'] = \yii\helpers\Url::to(['booking/manage', 'id' => $b->id]);
				} elseif ($b->isExpired) {
					$event['className'] .= ' js-expired fc-expired';
				}
			}

			if (($b->status != Booking::STATUS_STUB)) {
				$result[] = $borders[Calendar::BORDER_BEFORE];
			}

			$result[] = $event;

			if (($b->status != Booking::STATUS_STUB)) {
				$result[] = $borders[Calendar::BORDER_AFTER];
			}
		}

		return $result;
	}


	private function processClient(ActiveQuery $query)
	{
		$bookings = $query->with(['user', 'advertiser'])->all();
		$result = [];
		$nonAdv = Toolbox::currentNonAdvertiser();

		if (!$nonAdv) {
			throw new \yii\base\Exception('No logged in non-advertiser detected.');
		}

		foreach ($bookings as $b) {
			$borders = Calendar::generateEventBorders($b->from_date, $b->to_date);
			$borders[Calendar::BORDER_BEFORE]['id'] = $b->feedId . Calendar::BORDER_BEFORE;
			$borders[Calendar::BORDER_AFTER]['id'] = $b->feedId . Calendar::BORDER_AFTER;

			if ($b->user && $b->user->id == $nonAdv->id) {

				$event = [
//				'title' => Html::a($b->user->username, Toolbox::userPublicUrl($b->user), ['target' => '_blank']),
					'id' => $b->feedId,
					'title' => $b->user->username . '/' . $b->advertiser->user->username,
					'start' => Toolbox::sysFormatDateTime($b->from_date, 'T'),
					'end' => Toolbox::sysFormatDateTime($b->to_date, 'T'),
					'editable' => false,
					'className' => 'js-user-view fc-user-view ' . $b->statusClasses,
					'backgroundColor' => ($b->status == Booking::STATUS_APPROVED) ? Calendar::eventBgColorAccepted() : Calendar::eventBgColorPending(),
					'attributes' => $b->attributes,
				];
				$event['user_url'] = Toolbox::userPublicUrl($b->advertiser->user);

				if (!$b->isExpired) {
					$event['manage_url'] = \yii\helpers\Url::to(['booking/cancel', 'id' => $b->id]);
				} elseif ($b->isExpired) {
					$event['className'] .= ' js-expired fc-expired';
				}
			} else {
				$event = [
					'id' => $b->feedId,
					'title' => '',
					'start' => Toolbox::sysFormatDateTime($b->from_date, 'T'),
					'end' => Toolbox::sysFormatDateTime($b->to_date, 'T'),
					'editable' => false,
					'rendering' => 'background',
					'backgroundColor' => Calendar::eventBgColorDisabled(),
					'borderColor' => Calendar::eventBgColorDisabled(),
				];
			}


			$result[] = $borders[Calendar::BORDER_BEFORE];
			$result[] = $event;
			$result[] = $borders[Calendar::BORDER_AFTER];
		}

		return $result;
	}


}
