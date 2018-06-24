<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%payments_country}}".
 *
 * @property string $payment_id
 * @property integer $country_id
 *
 * @property PaymentsList $payment
 */
class PaymentsCountry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payments_country}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payment_id'], 'required'],
            [['country_id'], 'integer'],
            [['payment_id'], 'string', 'max' => 25],
            [['payment_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentsList::className(), 'targetAttribute' => ['payment_id' => 'payment_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'payment_id' => 'Payment ID',
            'country_id' => 'Country ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayment()
    {
        return $this->hasOne(PaymentsList::className(), ['payment_id' => 'payment_id']);
    }
}
