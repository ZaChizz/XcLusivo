<?php

namespace frontend\models;

use Yii;

use common\models\User;

/**
 * This is the model class for table "booking_requests".
 *
 * @property integer $id
 * @property integer $advertiser_id
 * @property integer $nonadvertiser_id
 * @property integer $request_status
 * @property integer $pay_with
 * @property integer $secure_booking
 * @property string $from_date
 * @property string $to_date
 *
 * @property PaymentMethods $payWith
 * @property Advertiser $advertiser
 * @property User $nonadvertiser
 */
class BookingRequests extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_CONFIRM = 2;
    const STATUS_EARLY = 3;
    const STATUS_REFUSE = 0;
    const ALERT_CONFIRM = 1;
    const ALERT_REFUSE = 2;
    const ALERT_DONE = 0;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'booking_requests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['advertiser_id', 'nonadvertiser_id', 'request_status', 'pay_with', 'secure_booking', 'from_date', 'to_date'], 'required'],
            [['advertiser_id', 'nonadvertiser_id', 'request_status', 'pay_with', 'secure_booking','alert','create_at'], 'integer'],
            [['from_date', 'to_date'], 'string', 'max' => 255],
            [['pay_with'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentMethods::className(), 'targetAttribute' => ['pay_with' => 'id']],
            [['advertiser_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertiser::className(), 'targetAttribute' => ['advertiser_id' => 'id']],
            [['nonadvertiser_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['nonadvertiser_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'advertiser_id' => Yii::t('app', 'Advertiser ID'),
            'nonadvertiser_id' => Yii::t('app', 'Nonadvertiser ID'),
            'request_status' => Yii::t('app', 'Request Status'),
            'pay_with' => Yii::t('app', 'Pay With'),
            'secure_booking' => Yii::t('app', 'Secure Booking'),
            'from_date' => Yii::t('app', 'From Date'),
            'to_date' => Yii::t('app', 'To Date'),
            'alert' => Yii::t('app', 'Alert'),
            'create_at' => Yii::t('app', 'Create at')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayWith()
    {
        return $this->hasOne(PaymentMethods::className(), ['id' => 'pay_with']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertiser()
    {
        return $this->hasOne(Advertiser::className(), ['id' => 'advertiser_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNonadvertiser()
    {
        return $this->hasOne(User::className(), ['id' => 'nonadvertiser_id']);
    }

    /**
     * @inheritdoc
     * @return BookingRequestsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BookingRequestsQuery(get_called_class());
    }

    public static function check($id)
    {
        $model = BookingRequests::find()
            ->where([
                'request_status' => BookingRequests::STATUS_ACTIVE,
                'nonadvertiser_id'=> Yii::$app->getUser()->id,
                'advertiser_id' => $id,
            ])
        ->orderBy('id')
        ->all();
        if($model)
            return false;
        else
            return true;
    }

    public function issetBookingRequest()
    {
        if($this->nonadvertiser_id == Yii::$app->getUser()->id)
            return true;
        else
            return false;
    }

    public function canConfirm()
    {
        if($this->request_status == BookingRequests::STATUS_ACTIVE)
            return true;
        else
            return false;
    }

    public function canRefuse()
    {
        if($this->request_status == BookingRequests::STATUS_EARLY || $this->request_status == BookingRequests::STATUS_REFUSE)
            return false;
        else
            return true;
    }


    public static function rangeModels($models)
    {
        $rangeModels['STATUS_ACTIVE'] = array();
        $rangeModels['STATUS_CONFIRM'] = array();
        $rangeModels['STATUS_EARLY'] = array();
        $rangeModels['STATUS_REFUSE'] = array();

        foreach($models as $value)
        {
            if($value->request_status == BookingRequests::STATUS_ACTIVE)
                $rangeModels['STATUS_ACTIVE'][] = $value;


            if($value->request_status == BookingRequests::STATUS_CONFIRM)
                $rangeModels['STATUS_CONFIRM'][] = $value;


            if($value->request_status == BookingRequests::STATUS_EARLY)
                $rangeModels['STATUS_EARLY'][] = $value;

            if($value->request_status == BookingRequests::STATUS_REFUSE)
                $rangeModels['STATUS_REFUSE'][] = $value;
        }

        return $rangeModels;
    }

    public static function checkAlert($models)
    {
        $message = array();
        foreach($models as $model)
        {
            if($model->alert)
                $message[] = $model;
        }
        return $message;
    }

    public static function loadModel2User($user_id)
    {
        if (($model = BookingRequests::find()->where(['nonadvertiser_id' => $user_id])->all()) !== null) {
            return $model;
        } else {
            return false;
        }
    }

    public static function loadModel2Advertiser($adv_id)
    {
        if (($model = BookingRequests::find()->where(['advertiser_id' => $adv_id])->all()) !== null) {
            return $model;
        } else {
            return false;
        }
    }
}
