<?php

namespace app\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property integer $chat_id
 * @property string $content
 * @property integer $sender
 * @property integer $created_at
 */
class Message extends \yii\db\ActiveRecord
{
    private $_userModel;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chat_id', 'created_at'], 'required'],
            [['chat_id', 'user_id', 'created_at'], 'integer'],
            [['content'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chat_id' => 'Chat ID',
            'content' => 'Content',
            'sender' => 'Sender',
            'created_at' => 'Created At',
        ];
    }

    public function getSender(){
        if ($this->user_id == Chat::CHAT_WITH_ADMIN) {
            return 'Admin';
        }
        if ($this->_userModel === null) {
            $this->_userModel = User::findOne($this->user_id);
        }
        if ($this->_userModel !== null) {
            return $this->_userModel->username;
        }
        return '*DELETED USER*';
    }
}
