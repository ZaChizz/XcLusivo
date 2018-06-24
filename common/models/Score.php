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
 * @property integer $amount
 * @property integer $valid_until
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $is_test
 *
 * @property Advertiser $advertiser
 * @property User $user
 */
class Score extends \yii\db\ActiveRecord
{


	/**
	 * 
	 * @return \common\models\ScoreQuery
	 */
	public static function find()
	{
		return new ScoreQuery(get_called_class());
	}


	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%scores}}';
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['advertiser_id', 'user_id', 'amount', 'valid_until', 'entity_class', 'entity_id', 'custom_id', 'is_test'], 'safe'],
			[['advertiser_id', 'valid_until', 'amount'], 'required'],
			[['advertiser_id', 'user_id'], 'integer', 'min' => 1],
			[['amount'], 'integer'],
			[['valid_until'], 'filter', 'filter' => function ($value) {
					return Toolbox::ensureTimestamp($value);
				}
			],
			['entity_class', 'required', 'when' => function($model) {
					return !empty($model->entity_id);
				}
			],
			['entity_id', 'required', 'when' => function($model) {
					return !empty($model->entity_class);
				}
			],
			['custom_id', 'required', 'when' => function($model) {
					return empty($model->entity_class) && empty($model->entity_id);
				}
			],
			['custom_id', 'string', 'max' => 255, 'skipOnEmpty' => true],

//			[['advertiser_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertiser::className(), 'targetAttribute' => 'id'],
//			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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


}
