<?php

namespace app\models;

use common\models\User;
use backend\models\Meassge;
use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property integer $id
 * @property integer $adv_id
 * @property integer $nadv_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Chat extends \yii\db\ActiveRecord
{
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
            [['adv_id', 'nadv_id', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'adv_id' => 'Adv ID',
            'nadv_id' => 'Nadv ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getUser($who)
    {
        switch ($who) {
            case 'adv_id':
                if ($this->adv_id == self::CHAT_WITH_ADMIN) {
                    return 'Admin';
                }
                $user = User::findOne($this->adv_id);
                return isset($user->username) ? $user->username : 'deleted_user';
            case 'nadv_id':
                if ($this->nadv_id == self::CHAT_WITH_ADMIN) {
                    return 'Admin';
                }
                $user = User::findOne($this->nadv_id);
                return isset($user->username) ? $user->username : 'deleted_user';
            default :
                return 'deleted_user';
        }
    }

    public function hasNewMessages()
    {
      if ($this->nadv_id == self::CHAT_WITH_ADMIN) {
        $message = Message::find()->select('id')->where(['chat_id' => $this->id])->andWhere(['not', ['user_id' => self::CHAT_WITH_ADMIN]])->andWhere(['read_at' => 0])->one();
        if (!empty($message->id)) {
          return true;
        }
      }
      return false;
    }

    public static function hasNewMessagesForAdmin()
    {
      $chatsId = [];
      $chats = self::find()->select('id')->where(['nadv_id' => self::CHAT_WITH_ADMIN])->all();
      foreach ($chats as $chat) {
        $chatsId[] = $chat->id;
      }
      if (!empty($chatsId)) {
        $message = Message::find()->select('id')->where(['in', 'chat_id', $chatsId])->andWhere(['not', ['user_id' => self::CHAT_WITH_ADMIN]])->andWhere(['read_at' => 0])->one();
        if (!empty($message->id)) {
          return true;
        }
      }
      return false;
    }
}
