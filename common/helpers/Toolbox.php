<?php


namespace common\helpers;

use Yii;
use common\models\User;
use yii\helpers\Url;

class Toolbox
{

	private static $_singletones = [];


	/**
	 * 
	 * @param string $key
	 * @param function $getter
	 * @param boolean $refresh
	 * @return mixed
	 */
	public static function singleton($key, $getter, $refresh = false)
	{
		if (!isset(self::$_singletones[$key]) || $refresh) {
			self::$_singletones[$key] = $getter();
		}

		return self::$_singletones[$key];
	}


	/**
	 * 
	 * @return \common\models\User
	 */
	public static function currentUser()
	{
		return self::singleton('currentUser', function() {
				return (Yii::$app->user->id) ? User::find()->with(['params'])->andWhere(['id' => Yii::$app->user->id])->one() : null;
			});
	}


	/**
	 * 
	 * @return \frontend\models\Advertiser
	 */
	public static function currentAdvertiser()
	{
		$user = self::currentUser();
		return ($user && $user->params) ? $user->params : null;
	}


	public static function currentNonAdvertiser()
	{
		$user = self::currentUser();
		return ($user && !$user->params) ? $user : null;
	}


	/**
	 * 
	 * @param mixed $ts
	 * @return int
	 */
	public static function ensureTimestamp($ts)
	{
		$result = (!filter_var($ts, FILTER_VALIDATE_INT)) ? strtotime($ts) : intval($ts);
		
		if ($result === false) {
			$result = strtotime(str_replace('/', '-', $ts));
		}
		
		if ($result === false) {
			throw new \yii\base\Exception('Invalid time value.');
		}
		
		return $result;
	}


	/**
	 * 
	 * @param mixed $ts
	 * @return string
	 */
	public static function sysFormatDate($ts = null)
	{
		$ts = (null === $ts) ? time() : self::ensureTimestamp($ts);
		return date('Y-m-d', $ts);
	}


	/**
	 * 
	 * @param mixed $ts
	 * @param boolean $useSeconds
	 * @return string
	 */
	public static function sysFormatTime($ts = null, $useSeconds = false)
	{
		$ts			 = (null === $ts) ? time() : self::ensureTimestamp($ts);
		$template	 = ($useSeconds) ? 'H:i:s' : 'H:i';
		return date($template, $ts);
	}


	/**
	 * 
	 * @param mixed $ts
	 * @param string $separator
	 * @param boolean $useSeconds
	 * @return string
	 */
	public static function sysFormatDateTime($ts = null, $separator = ' ', $useSeconds = false)
	{
		$ts = (null === $ts) ? time() : self::ensureTimestamp($ts);
		return date('Y-m-d', $ts) . $separator . date((($useSeconds) ? 'H:i:s' : 'H:i'), $ts);
	}


	/**
	 * 
	 * @param mixed $ts
	 * @return string
	 */
	public static function sysFormatSqlDateTime($ts = null)
	{
		$ts			 = (null === $ts) ? time() : self::ensureTimestamp($ts);
		$template	 = 'Y-m-d H:i:s';
		return date($template, $ts);
	}


	/**
	 * 
	 * @param mixed $ts
	 * @return string
	 */
	public static function formatDate($ts = null)
	{
		$ts = (null === $ts) ? time() : self::ensureTimestamp($ts);
		return date('d/m/Y', $ts);
	}


	/**
	 * 
	 * @param mixed $ts
	 * @param boolean $useSeconds
	 * @return string
	 */
	public static function formatTime($ts = null, $useSeconds = false)
	{
		return self::sysFormatTime($ts, $useSeconds);
	}
	
	/**
	 * 
	 * @param mixed $ts
	 * @param string $separator
	 * @param boolean $useSeconds
	 * @return string
	 */
	public static function formatDateTime($ts = null, $separator = ' ', $useSeconds = false)
	{
		$ts = (null === $ts) ? time() : self::ensureTimestamp($ts);
		return self::formatDate($ts) . $separator . self::formatTime($ts, $useSeconds);
	}
	
	/**
	 * 
	 * @return string
	 */
	public static function popupAuthMessage()
	{
		return Yii::t('app', 'Please login or register.');
	}
	
	
	public static function userPublicUrl(User $user)
	{
		if ($user->isAdvertiser) {
			return Url::to(['site/advertiser', 'id' => $user->params->id]);
		} else {
			return Url::to(['non-advertiser/non-advertiser-profile', 'id' => $user->id]);
		}
	}
}
