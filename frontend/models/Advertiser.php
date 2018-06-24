<?php


namespace frontend\models;

use Yii;
use common\models\User;
use common\models\Booking;
use frontend\models\Services;
use common\interfaces\IBookingParticipant;
use common\models\AdvertiserScore;


/**
 * This is the model class for table "advetiser".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property integer $type
 * @property integer $price
 * @property string $date
 * @property integer $age
 * @property integer $height
 * @property integer $weight
 * @property integer $hair
 * @property integer $eye
 * @property integer $skin
 * @property integer $silicone
 * @property string $nationality
 * @property string $offering
 * @property string $receiving
 * @property string $desc
 * @property integer $online
 * @property string $payment_id
 * @property integer $sex_id
 *
 * @property User $user
 * @property AdvetiserImage[] $advetiserImages
 * @property AdvertiserScore $advertiserScores
 */
class Advertiser extends \yii\db\ActiveRecord implements IBookingParticipant
{

    // Non-standard scenarios
    const SC_SIGNUP = 'signup';

    const ONLINE_BASED_ON_BOOKING = 0;
    const ONLINE_MANUAL_ONLINE = 1;
    const ONLINE_MANUAL_OFFLINE = 2;

    /**
     * @inheritdoc
     */
    public $onlineStatus;
    public $receiving_as_value	 = array();
    public $offering_as_value	 = array();
    public $receiving_as_id		 = array();
    public $offering_as_id		 = array();
    public $services             = array();
    public $phone;
    public $username;
    public $sexList = [];
    public $sexListTitle = [];

	public static function tableName()
	{
		return '{{%advertiser}}';
	}


	public function behaviors()
	{
		return [
			\common\behaviors\BookingParticipantBehavior::className(),
		];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SC_SIGNUP]	 = [];
        return $scenarios;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'height', 'weight', 'hair_id', 'eye_id', 'skin_id', 'silicone', 'online', 'nationality_id', 'cities_id', 'country_id', 'bra_id', 'shoe_size'], 'integer'],
            [['desc'], 'string'],
            [['age'], 'integer', 'min' => 18],
            [['title', 'date', 'offering', 'receiving','username'], 'string', 'max' => 255],
						[['payment_id'], 'string', 'max' => 25],
            [['price','phone'], 'safe']
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'			 => Yii::t('app', 'ID'),
            'user_id'		 => Yii::t('app', 'User ID'),
            'title'			 => Yii::t('app', 'Title'),
            'price'			 => Yii::t('app', 'Price'),
            'date'			 => Yii::t('app', 'Date'),
            'age'			 => Yii::t('app', 'Age'),
            'height'		 => Yii::t('app', 'Height'),
            'weight'		 => Yii::t('app', 'Weight'),
            'hair_id'		 => Yii::t('app', 'Hair'),
            'eye_id'		 => Yii::t('app', 'Eye'),
            'skin_d'		 => Yii::t('app', 'Skin'),
            'silicone'		 => Yii::t('app', 'Silicone breasts'),
            'nationality_id' => Yii::t('app', 'Nationality'),
            'cities_id'		 => Yii::t('app', 'City'),
            'offering'		 => Yii::t('app', 'Offering'),
            'receiving'		 => Yii::t('app', 'Receiving'),
            'desc'			 => Yii::t('app', 'Desc'),
            'online'		 => Yii::t('app', 'Online'),
            'bra_id'		 => Yii::t('app', 'Bra size'),
            'shoe_size'		 => Yii::t('app', 'Shoe size'),
            'payment_id'		 => Yii::t('app', 'Payment ID'),
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'cities_id']);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    public function getBra()
    {
        return $this->hasOne(Bra::className(), ['id' => 'bra_id']);
    }

	public function getHair()
	{
		return $this->hasOne(Colors::className(), ['id' => 'hair_id']);
	}

    public function getEye()
    {
        return $this->hasOne(Colors::className(), ['id' => 'eye_id']);
    }

    public function getSkin()
    {
        return $this->hasOne(Colors::className(), ['id' => 'skin_id']);
    }

    public function getNationality()
    {
        return $this->hasOne(Nationality::className(), ['id' => 'nationality_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(AdvertiserImage::className(), ['id_advertiser' => 'id']);
    }

	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertiserScores()
    {
        return $this->hasOne(AdvertiserScore::className(), ['advertiser_id' => 'id']);
    }

	
	/**
	 * Shortcut to getAdvertiserScores with NULL checking
	 * 
	 * @return int
	 */
	public function getPoints()
	{
		return ((boolean) $this->advertiserScores) ? $this->advertiserScores->amount_sum : 0;
	}
	
    public function getBookingRequests()
    {
        return $this->hasMany(BookingRequests::className(), ['advertiser_id' => 'id']);
    }


    /**
     * @inheritdoc
     * @return AdvetiserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdvertiserQuery(get_called_class());
    }


    public function afterFind()
    {
        if ($this->isOnlineManual()) {
          $this->onlineStatus = ($this->online == self::ONLINE_MANUAL_OFFLINE ? 'offline' : 'online');
        } elseif (($this->user->time_session + 310) > time()) {
            $this->onlineStatus	 = 'online';
        } else {
            $this->onlineStatus	 = 'offline';
        }
        $this->loadServices();
        $this->phone = $this->user->phone;
        $this->username = $this->user->username;

        $this->receiving();
        $this->offering();
    }

    public function loadServices()
    {
      if (empty($this->services)) {
        $this->services = $this->refactorArrayModel(Services::find()->asArray()->all());
      }
    }

    public static function refactorArrayModel($model)
    {
        $rez = array();
        foreach ($model as $value) {
            $rez[$value['id']] = $value['title'];
        }
        return $rez;
    }


    public function receiving()
    {
        if (!empty($this->receiving)) {
            $arr = explode(',', $this->receiving);
            array_shift($arr);
            array_pop($arr);
            foreach ($arr as $value) {
                if (isset($this->services[$value])) {
                    $this->receiving_as_value[] = $this->services[$value];
                    $this->receiving_as_id[] = $value;
                }
            }
            return true;
        } else {
            return false;
        }
    }

	public function offering()
	{
		if (!empty($this->offering)) {
			$arr = explode(',', $this->offering);
			array_shift($arr);
			array_pop($arr);
			foreach ($arr as $value) {
					if (isset($this->services[$value])) {
							$this->offering_as_value[] = $this->services[$value];
							$this->offering_as_id[] = $value;
					}
			}
			return true;
		} else
			return false;
	}

	/**
	 *
	 * @return ActiveQuery
	 */
	public function getBookings()
	{
		return $this->hasMany(Booking::className(), ['advertiser_id' => 'id']);
	}

  /**
   *
   * @return ActiveQuery
   */
  public function getSex()
	{
		return $this->hasOne(Sex::className(), ['id' => 'sex_id']);
	}

  public function afterSave($insert, $changedAttributes)
  {
      parent::afterSave($insert, $changedAttributes);
      if ($insert || array_key_exists('age', $changedAttributes)) {
          $user = $this->user;
          $user->status = $this->age >= 18 ? User::STATUS_ACTIVE : User::STATUS_AGE_BLOCKED;
          if (!$user->save()) {
            print_r($user->errors);
          }
      }
  }

  public function getPause()
  {
    return $this->user->status == User::STATUS_PAUSE;
  }

  public function setPause($pauseState)
  {
    if ($pauseState) {
      $this->user->status = User::STATUS_PAUSE;
    } else {
      $this->user->status = ($this->age >= 18 ? User::STATUS_ACTIVE : User::STATUS_AGE_BLOCKED);
    }
    $this->user->save();
  }

  public function isOnlineBasedOnBooking()
  {
    return $this->online == self::ONLINE_BASED_ON_BOOKING;
  }

  public function isOnlineManual()
  {
    return $this->online == self::ONLINE_MANUAL_ONLINE || $this->online == self::ONLINE_MANUAL_OFFLINE;
  }

  public function isFavorit($user_id)
  {
    return Favorits::find()->where(['user_id' => $user_id])->andWhere(['advertiser_id' => $this->id])->count() > 0;
  }
}
