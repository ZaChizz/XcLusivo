<?php


namespace app\models;

use Yii;


/**
 * This is the model class for table "{{%payment_history}}".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $payer_id
 * @property integer $receiver_id
 * @property string $amount
 * @property string $currency
 * @property string $status
 * @property string $payment_id
 */
class PaymentHistory extends \yii\db\ActiveRecord
{


	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%payment_history}}';
	}


	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'timestamp' => [
				'class' => 'yii\behaviors\TimestampBehavior',
				'attributes' => [
					\yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
					\yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
			],
		];
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['created_at', 'updated_at'], 'safe'],
			[['payer_id', 'receiver_id', 'amount', 'currency', 'status', 'payment_id'], 'required'],
			[['payer_id', 'receiver_id'], 'integer'],
			[['amount'], 'number'],
			[['status'], 'string'],
			[['currency'], 'string', 'max' => 3],
			[['payment_id'], 'string', 'max' => 25],
		];
	}


	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'payer_id' => 'Payer ID',
			'receiver_id' => 'Receiver ID',
			'amount' => 'Amount',
			'currency' => 'Currency',
			'status' => 'Status',
			'payment_id' => 'Payment ID',
		];
	}


}
