<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%payments_list}}".
 *
 * @property string $payment_id
 * @property integer $enabled_for_payment
 * @property integer $enabled_for_payout
 *
 * @property PaymentsCountry[] $paymentsCountries
 */
class PaymentsList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payments_list}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payment_id'], 'required'],
            [['enabled_for_payment', 'enabled_for_payout'], 'integer'],
            [['payment_id'], 'string', 'max' => 25],
            [['payment_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'payment_id' => 'Payment ID',
            'enabled_for_payment' => 'Enabled For Payment',
            'enabled_for_payout' => 'Enabled For Payout',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentsCountries()
    {
        return $this->hasMany(PaymentsCountry::className(), ['payment_id' => 'payment_id']);
    }
}
