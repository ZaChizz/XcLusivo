<?php

namespace frontend\models;
use common\models\User;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property integer $id
 * @property integer $adv_id
 * @property integer $nadv_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $adv
 * @property User $nadv
 * @property Message[] $messages
 */
class Chat extends \yii\db\ActiveRecord
{
    const CHATS_PER_PAGE = 10;
    const CHAT_WITH_ADMIN = -1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adv_id', 'nadv_id', 'created_at', 'updated_at'], 'required'],
            [['adv_id', 'nadv_id', 'created_at', 'updated_at'], 'integer'],
            [['adv_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['adv_id' => 'id']],
            [['nadv_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['nadv_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'adv_id' => Yii::t('app', 'Adv ID'),
            'nadv_id' => Yii::t('app', 'Nadv ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdv()
    {
        return $this->hasOne(User::className(), ['id' => 'adv_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNadv()
    {
        return $this->hasOne(User::className(), ['id' => 'nadv_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['chat_id' => 'id']);
    }

    public static function getChatListFor($userId, $offs = 0)
    {
        $offs = $offs * self::CHATS_PER_PAGE;
        return Chat::find()->where(['nadv_id' => $userId])->orWhere(['adv_id' => $userId])->orderBy(['updated_at' => SORT_DESC])->limit(self::CHATS_PER_PAGE)->offset($offs)->all();
    }

    public static function getAllFor($userId)
    {
        return Chat::find()->where(['nadv_id' => $userId])->orWhere(['adv_id' => $userId])->all();
    }

    public static function getChatsCountFor($userId)
    {
        return Chat::find()->where(['nadv_id' => $userId])->orWhere(['adv_id' => $userId])->count();
    }

    public static function getChatWithAdmin($userId)
    {
        $model = Chat::find()->where(['adv_id' => $userId])->andWhere(['nadv_id' => self::CHAT_WITH_ADMIN])->one();
        if ($model == null) {
            $model = new Chat();
            $model->adv_id = $userId;
            $model->nadv_id = self::CHAT_WITH_ADMIN;
            $model->created_at = time();
            $model->updated_at = time();
            $model->save();
        }
        return $model;
    }
}
