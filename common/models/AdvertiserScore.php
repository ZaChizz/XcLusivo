<?php


namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use frontend\models\Advertiser;



/**
 * This is the model class for view "advertiser_scores".
 *
 * @property integer $id
 * @property integer $advertiser_id
 * @property integer $amount_sum
 *
 * @property Advertiser $advertiser
 */
class AdvertiserScore extends \yii\db\ActiveRecord
{


	

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%advertiser_scores}}';
	}


	public static function primaryKey()
	{
		return 'advertiser_id';
	}


	public function getId()
	{
		return $this->advertiser_id;
	}


	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAdvertiser()
	{
		return $this->hasOne(Advertiser::className(), ['id' => 'advertiser_id']);
	}


}
