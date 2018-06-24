<?php


namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use frontend\models\Advertiser;
use common\models\User;
use common\helpers\Toolbox;


/**
 * This is the model class for table "bookings".
 *
 * @property integer $id
 * @property integer $advertiser_id
 * @property integer $user_id
 * @property integer $status
 * @property string $from_date
 * @property string $to_date
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Advertiser $advertiser
 * @property User $user
 */
class Booking extends \yii\db\ActiveRecord
{

	const STATUS_PENDING = 'Pending';
	const STATUS_APPROVED = 'Approved';
	const STATUS_STUB = 'Stub';


	/**
	 * 
	 * @return \common\models\BookingQuery
	 */
	public static function find()
	{
		return new BookingQuery(get_called_class());
	}



	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%bookings}}';
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['from_date', 'to_date'], 'safe'],
			[['advertiser_id', 'status', 'from_date', 'to_date'], 'required'],
			[['advertiser_id', 'user_id', 'from_date', 'to_date'], 'integer'],
			[['from_date', 'to_date'], 'filter', 'filter' => function ($value) {
					return Toolbox::ensureTimestamp($value);
				}],
//			[['advertiser_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertiser::className(), 'targetAttribute' => ['advertiser_id' => 'id']],
			[['advertiser_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertiser::className(), 'targetAttribute' => 'id'],
			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
		];
	}


	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
		];
	}


	public function behaviors()
	{
		return [
			\common\behaviors\ExtractErrorBehavior::className(),
			\common\behaviors\CaptureRequestBehavior::className(),
			'timestamp' => [
				'class' => 'yii\behaviors\TimestampBehavior',
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
			],
		];
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
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}


	public function getFeedId()
	{
		return 'b' . $this->id . 'u' . $this->user_id . 'a' . $this->advertiser_id;
	}


	/**
	 * 
	 * @return string
	 */
	public function getStatusClasses()
	{
		$suffix = strtolower($this->status);
		$result = 'js-status-' . $suffix . ' ' . 'fc-status-' . $suffix;
		return $result;
	}

	
	public function approve()
	{
		$this->status = self::STATUS_APPROVED;
		$this->save(false, ['status']);
		
		// TODO: other actions like emailing or messaging
	}

	/**
	 * Decline a booking by advertiser
	 */
	public function decline()
	{
		$this->delete();
		// TODO: other actions like emailing or messaging
	}
	
	/**
	 * Cancelling booking by non-advertiser
	 */
	public function cancel()
	{
		$this->delete();
		// TODO: other actions like emailing or messaging
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function getIsExpired()
	{
		$expiration = time()+\common\helpers\Calendar::eventExpirationLimit()*60*60;
		return $expiration > $this->from_date;
	}
	
}
