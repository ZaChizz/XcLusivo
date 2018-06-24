<?php


namespace common\helpers;

use common\models\Score;
use yii\db\ActiveRecord;
use common\helpers\Toolbox;


class Scoring
{


	/**
	 * 
	 * @param int $advertiserId
	 * @param int $amount
	 * @param int $validDays
	 * @param ActiveRecord $entityOrCustomId
	 * @param int $nonAdvUserId
	 * @return Score
	 */
	public static function add($advertiserId, $amount, $validDays, $entityOrCustomId, $nonAdvUserId = null)
	{
		return self::addByAttributes(self::prepare($advertiserId, $amount, $validDays, $entityOrCustomId, $nonAdvUserId));
	}


	/**
	 * 
	 * @param array $attributes
	 * @return Score
	 * @throws \yii\base\Exception
	 */
	public static function addByAttributes($attributes)
	{
		$model = new Score();
		$model->attributes = $attributes;

		if (!$model->save()) {
			throw new \yii\base\Exception($model->getFirstErrorMessage());
		} else {
			return $model;
		}
	}


	/**
	 * 
	 * @param int $advertiserId
	 * @param int $amount
	 * @param int $validDays
	 * @param ActiveRecord $entityOrCustomId
	 * @param int $nonAdvUserId
	 * @return array
	 */
	public static function prepare($advertiserId, $amount, $validDays, $entityOrCustomId, $nonAdvUserId = null)
	{
		$params = [];
		$params['advertiser_id'] = $advertiserId;
		$params['valid_until'] = self::daysToTimestamp($validDays, time());
		$params['amount'] = $amount;

		if ($entityOrCustomId instanceof ActiveRecord) {
			$params['entity_id'] = $entityOrCustomId->primaryKey;
			$params['entity_class'] = get_class($entityOrCustomId);
			$params['custom_id'] = get_class($entityOrCustomId).'|'.$entityOrCustomId->primaryKey;
		} else {
			$params['custom_id'] = (string) $entityOrCustomId;
		}

		if ($nonAdvUserId) {
			$params['user_id'] = $nonAdvUserId;
		}

		return $params;
	}


	/**
	 * 
	 * @param int $days Amount of days to convert
	 * @param int $from Add to timestamp (default: now)
	 * @return int
	 * @throws \yii\base\Exception
	 */
	public static function daysToTimestamp($days, $from = null)
	{
		if (null != $from) {
			$from = Toolbox::ensureTimestamp($from);
		} else {
			$from = 0;
		}

		if (!filter_var($days, FILTER_VALIDATE_INT) || $days < 0) {
			throw new \yii\base\Exception('Invalid amount of days');
		}

		return $from + $days * 60 * 60 * 24;
	}


	public static function expirationLimit()
	{
		return 100 * 24 * 60 * 60; // ~ half-year
	}


	public static function purgeExpired()
	{
		
	}


}
