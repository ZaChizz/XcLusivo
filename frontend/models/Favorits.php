<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%favorits}}".
 *
 * @property integer $user_id
 * @property integer $advertiser_id
 *
 * @property Advertiser $user
 * @property User $user0
 */
class Favorits extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%favorits}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'advertiser_id'], 'required'],
            [['user_id', 'advertiser_id'], 'integer'],
            [['advertiser_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertiser::className(), 'targetAttribute' => ['advertiser_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'advertiser_id' => 'Advertiser ID',
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
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }

    public static function getAll($user_id = false)
    {
      if (!$user_id) {
        $user_id = \Yii::$app->getUser()->id;
      }
      return self::findAll(['user_id' => $user_id]);
    }
}
