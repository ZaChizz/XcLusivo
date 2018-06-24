<?php


namespace common\helpers;

use Yii;
use common\helpers\Toolbox;
use common\interfaces\IBookingParticipant;
use frontend\models\Advertiser;
use common\models\Booking;
use yii\helpers\Url;


class Calendar
{

	const BORDER_BEFORE = 'before';
	const BORDER_AFTER = 'after';


	public static function eventBgColorDisabled()
	{
		return '#999999';
	}


	public static function eventBgColorPending()
	{
		return '#FF6666';
	}


	public static function eventBgColorAccepted()
	{
		return '#66FF66';
	}


	/**
	 * 
	 * @return int In hours
	 */
	public static function eventBorderPeriod()
	{
		return 1;
	}

	/**
	 * 
	 * @return int In hours
	 */
	public static function eventExpirationLimit()
	{
		return 1;
	}


	public static function generateDisabledRange($start, $end, $asSingleItem = true)
	{
		$bgEvent = [
			'title' => false,
			'start' => Toolbox::sysFormatDateTime($start, 'T'),
			'end' => Toolbox::sysFormatDateTime($end, 'T'),
			'editable' => false,
			'rendering' => 'background',
			'backgroundColor' => self::eventBgColorDisabled(),
			'borderColor' => self::eventBgColorDisabled(),
		];

		return $asSingleItem ? $bgEvent : [$bgEvent];
	}


	/**
	 * 
	 * @param int $start Stert time of source event
	 * @param int $end End time of source event
	 * @param boolean $useAssocKeys Use 'before','after' as array keys for border events if true, else - 0,1
	 * @return array
	 */
	public static function generateEventBorders($start, $end, $useAssocKeys = true)
	{
		$start = Toolbox::ensureTimestamp($start);
		$end = Toolbox::ensureTimestamp($end);
		$borderSeconds = self::eventBorderPeriod() * 60 * 60;

		$bgEvents = [];
		$bgEvents[($useAssocKeys) ? self::BORDER_BEFORE : 0] = self::generateDisabledRange($start - $borderSeconds, $start);
		$bgEvents[($useAssocKeys) ? self::BORDER_AFTER : 1] = self::generateDisabledRange($end, $end + $borderSeconds);

		return $bgEvents;
	}


	/**
	 * 
	 * @param Booking $b
	 * @return array
	 */
	public static function stubEvent(Booking $b)
	{
		$event = [
			'id' => $b->feedId,
			'title' => Yii::t('booking', 'Disabled'),
			'start' => Toolbox::sysFormatDateTime($b->from_date, 'T'),
			'end' => Toolbox::sysFormatDateTime($b->to_date, 'T'),
			'className' => 'js-user-view fc-user-view ' . $b->statusClasses,
			'editable' => false,
			'backgroundColor' => self::eventBgColorDisabled(),
			'borderColor' => self::eventBgColorDisabled(),
			'attributes' => $b->attributes,
		];

		$event['manage_url'] = \yii\helpers\Url::to(['booking/manage', 'id' => $b->id]);
		return $event;
	}


	/**
	 * 
	 * @param Advertiser $model
	 * @return string
	 */
	public static function url(Advertiser $model)
	{
		return Url::toRoute(['site/calendar', 'id' => $model->id]);
		/*
		  if (Toolbox::currentNonAdvertiser()) {
		  return Url::toRoute(['non-advertiser/booking', 'id' => $model->id]);
		  } else {
		  return Url::toRoute(['advertiser/calendar', 'id' => $model->id]);
		  }
		 * 
		 */
	}


}
