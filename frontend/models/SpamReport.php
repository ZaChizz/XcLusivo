<?php

namespace frontend\models;

use Yii;
use yii\web\User;

/**
 * This is the model class for table "spam_reports".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $sender_id
 * @property string $text
 * @property integer $created_at
 * @property integer $on_whom
 */
class SpamReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%spam_reports}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'sender_id', 'created_at', 'on_whom'], 'integer'],
            [['text'], 'string'],
            [['created_at', 'on_whom', 'sender_id'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'From',
            'sender_id' => 'Sender',
            'on_whom' => 'On whom',
            'text' => 'Text',
            'created_at' => 'Created At',
        ];
    }

    public function getSender(){
        $user = \common\models\User::findOne($this->sender_id);
        return isset($user->username) ? $user->username : \Yii::t('app', 'user_deleted...');
    }

    public function getOnWhom()
    {
      $user = \common\models\User::findOne($this->on_whom);
      return isset($user->username) ? $user->username : \Yii::t('app', 'user_deleted...');
    }
}
