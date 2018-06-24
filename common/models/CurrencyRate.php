<?php


namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\helpers\Toolbox;

;


/**
 * This is the model class for table "currency_rates".
 *
 * @property integer $id
 * @property string $code
 * @property float $rate
 */
class CurrencyRate extends \yii\db\ActiveRecord
{


	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%currency_rates}}';
	}


	/**
	 * 
	 * @return CurrencyRate[]
	 */
	public static function rateMap()
	{
		return Toolbox::singleton('currencyRateMap', function() {
				$all = CurrencyRate::find()->all();
				$result = [];

				foreach ($all as $model) {
					$result[$model->code] = $model;
				}

				return $result;
			});
	}


	public static function exchange($value, $fromCode, $toCode)
	{
		$map = self::rateMap();

		if (!isset($map[$fromCode])) {
			throw new \yii\base\Exception('Unknown currency code "' . $fromCode . '".');
		}

		if (!isset($map[$toCode])) {
			throw new \yii\base\Exception('Unknown currency code "' . $toCode . '".');
		}

		$destination = $map[$toCode];
		$source = $map[$fromCode];
		$result = $value / $source->rate * $destination->rate;
		return $result;
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['code', 'rate'], 'safe'],
		];
	}


	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'code' => Yii::t('app', 'Code'),
			'rate' => Yii::t('app', 'Rate'),
		];
	}


	/**
	 * 
	 * @param float $value
	 * @param string $toCode
	 * @return float
	 */
	public function exchangeTo($value, $toCode)
	{
		return self::exchange($value, $this->code, $toCode);
	}


	/**
	 * 
	 * @param float $value
	 * @param string $fromCode
	 * @return float
	 */
	public function exchangeFrom($value, $fromCode)
	{
		return self::exchange($value, $fromCode, $this->code);
	}


}
