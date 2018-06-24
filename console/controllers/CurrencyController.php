<?php


namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\CurrencyRate;


class CurrencyController extends Controller
{

	/**
	 * 
	 * @return \common\components\Fixer
	 */
	public static function fixer()
	{
		return Yii::$app->fixer;
	}


	public function actionRates()
	{
		self::out('');
		self::out('Begin of Currency Rates Update');
		$rates = self::fixer()->rates;
		self::updateRate('USD', 1);
		
		foreach ($rates as $code => $rate) {
			self::updateRate($code, $rate);
		}

		self::out('End of Currency Rates Update');
		self::out('');
	}
	
	
	protected static function updateRate($code, $rate)
	{
		$code = strtoupper($code);
		$rate = floatval($rate);
		self::out($code.': '.$rate, 1);
		
		$model = CurrencyRate::find()->where(['code' => $code])->one();
		
		if (!$model) {
			$model = new CurrencyRate();
		}

		$model->attributes = [
			'code' => $code,
			'rate' => $rate,
		];

		if (!$model->save()) {
			$errors = $model->errors;
			$firstAttr = reset($errors);
			$firstError = reset($firstAttr);
			throw new \yii\base\Exception($firstError);
		}
		
		return $model;
	}

	/**
	 * 
	 * @param string $string
	 * @param int $level
	 * @return void
	 */
	protected static function out($string, $level = 0)
	{
		$prefix = str_pad('', $level, "\t");
		echo $prefix . $string . "\r\n";
	}


}
