<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%currency}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $symbol_left
 * @property string $symbol_right
 * @property double $value
 * @property integer $status
 * @property string $date_modified
 */
class Currency extends \yii\db\ActiveRecord
{
    private static $currencyData = [];
    private static $defCurrency;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%currency}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'value', 'status'], 'required'],
            [['value'], 'number'],
            [['status'], 'integer'],
            [['date_modified'], 'safe'],
            [['code'], 'string', 'max' => 3],
            [['symbol_left', 'symbol_right'], 'string', 'max' => 12],
        ];
    }

    private static function initData()
    {
        $model = Currency::findAll(['status' => 1]);
        if ($model) {
            self::$currencyData = [];
            foreach ($model as $currency) {
                self::$currencyData[$currency->code] = $currency;
                if ($currency->value == 1) {
                    self::$defCurrency = $currency->code;
                }
            }
        }
    }

    /**
    * Convert currency
    * @param number $amount
    * @param string $fromCurrency code of currency
    * @param string $toCurrency code of currency
    * @return number
    */
    public static function convert($amount, $fromCurrency, $toCurrency)
    {
        $sum = 0;
        if (empty(self::$currencyData)) {
            self::initData();
        }
        if (!empty(self::$currencyData) && isset(self::$currencyData[$fromCurrency]) && isset(self::$currencyData[$toCurrency])) {
            if (self::$defCurrency == $fromCurrency) {
                $sum = $amount * self::$currencyData[$toCurrency]->value;
            } else if (self::$defCurrency == $toCurrency) {
                $sum =$amount / self::$currencyData[$fromCurrency]->value;
            } else {
                $sum = self::convert($amount, $fromCurrency, self::$defCurrency);
                $sum = self::convert($sum, self::$defCurrency, $toCurrency);
            }
        }
        return $sum;
    }

    /**
    * Format price in currency
    * @param number $amount
    * @param string $currency code of currency
    * @return strig
    */
    public static function format($amount, $currency)
    {
        $s = $amount.' '.$currency;
        if (empty(self::$currencyData)) {
            self::initData();
        }
        if (!empty(self::$currencyData) && isset(self::$currencyData[$currency]) && (!empty(self::$currencyData[$currency]->symbol_left) || !empty(self::$currencyData[$currency]->symbol_right))) {
            $s = trim(self::$currencyData[$currency]->symbol_left.$amount.self::$currencyData[$currency]->symbol_right);
        }
        return $s;
    }
}
