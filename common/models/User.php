<?php


namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\interfaces\IBookingParticipant;
use frontend\models\Advertiser;
use frontend\models\Reviews;
use common\helpers\Toolbox;


/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface, IBookingParticipant
{

	const STATUS_DELETED = 0;
	const STATUS_AGE_BLOCKED = 5;
	const STATUS_PAUSE = 7;
	const STATUS_ACTIVE = 10;
	const TYPE_ADVERTISER = 0;
	const TYPE_NON_ADVERTISER = 1;


	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%user}}';
	}


	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
			\common\behaviors\BookingParticipantBehavior::className(),
		];
	}


	public function afterSave($insert, $changedAttributes)
	{
		parent::afterSave($insert, $changedAttributes);
		if ($insert || isset($changedAttributes['type'])) {
			$auth = Yii::$app->authManager;
			$AdvetiserRole = $auth->getRole('Advetiser');
			$NONAdvetiserRole = $auth->getRole('NON Advetiser');
			$auth->revoke($AdvetiserRole, $this->id);
			$auth->revoke($NONAdvetiserRole, $this->id);
			if ($this->type == self::TYPE_NON_ADVERTISER) {
				$auth->assign($NONAdvetiserRole, $this->id);
			} else {
				$auth->assign($AdvetiserRole, $this->id);
			}
		}
	}


	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			if ($insert && $this->type == self::TYPE_ADVERTISER) {
				$this->status = self::STATUS_AGE_BLOCKED;
			}
			return true;
		}
		return false;
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['status', 'default', 'value' => self::STATUS_AGE_BLOCKED],
			['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_AGE_BLOCKED, self::STATUS_PAUSE]],
			[['status', 'type', 'phone'], 'safe'],
			[['email'], 'email'],
			['phone', 'default', 'value' => ''],
			['time_session', 'default', 'value' => 0],
			[['time_session'], 'integer'],
			[['username'], 'unique'],
			[['social_services', 'username', 'auth_key'], 'string', 'max' => 255],
			['password', 'required', 'on' => ['create']],
			['email', 'unique', 'on' => ['create']],
			['password', 'string', 'min' => 6],
		];
	}


	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id)
	{
		return static::findOne(['id' => $id, ['in', 'status', [self::STATUS_ACTIVE, self::STATUS_AGE_BLOCKED, self::STATUS_PAUSE]]]);
	}


	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	}


	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
	}


	public static function findByEAuth($service)
	{
		if (!$service->getIsAuthenticated()) {
			throw new ErrorException('EAuth user should be authenticated before creating identity.');
		}

		$model = User::findByUsername($service->getAttribute('name'));
		if (is_null($model)) {
			$model = new User();
			$model->username = $service->getAttribute('name');
			$model->auth_key = md5($service->getId());
			$model->social_services = $service->getServiceName();
			$model->type = User::TYPE_NON_ADVERTISER;
			$model->email = $service->getId() . '@nonadv.com';
			$model->save();
		}

		return $model;
	}


	/**
	 * Finds user by password reset token
	 *
	 * @param string $token password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token)
	{
		if (!static::isPasswordResetTokenValid($token)) {
			return null;
		}

		return static::findOne([
				'password_reset_token' => $token,
				'status' => self::STATUS_ACTIVE,
		]);
	}


	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token password reset token
	 * @return boolean
	 */
	public static function isPasswordResetTokenValid($token)
	{
		if (empty($token)) {
			return false;
		}

		$timestamp = (int) substr($token, strrpos($token, '_') + 1);
		$expire = Yii::$app->params['user.passwordResetTokenExpire'];
		return $timestamp + $expire >= time();
	}


	/**
	 * @inheritdoc
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}


	/**
	 * @inheritdoc
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}


	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}


	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}


	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password_hash = Yii::$app->security->generatePasswordHash($password);
	}


	public function getPassword()
	{
		return '';
	}


	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		$this->auth_key = Yii::$app->security->generateRandomString();
		return true;
	}


	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken()
	{
		$this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
	}


	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken()
	{
		$this->password_reset_token = null;
	}


	public function getAvatar()
	{
		return '/images/img1.jpg';
	}


	public function getParams()
	{
		return $this->hasOne(Advertiser::className(), ['user_id' => 'id']);
	}


	/**
	 * @inheritdoc
	 */
	public function getBookings()
	{
		return $this->hasMany(Booking::className(), ['user_id' => 'id']);
	}


	/**
	 *
	 * @return boolean
	 */
	public function getIsAdvertiser()
	{
		return (boolean) $this->params;
	}


	public function getStatusName()
	{
		switch ($this->status) {
			case self::STATUS_AGE_BLOCKED:
				return 'Lock by age';
				break;

			case self::STATUS_DELETED:
				return 'Banned';
				break;

			case self::STATUS_PAUSE:
				return 'On pause';
				break;

			case self::STATUS_ACTIVE:
				return 'Active';
				break;

			default:
				return 'Unknown status';
		}
	}


}
