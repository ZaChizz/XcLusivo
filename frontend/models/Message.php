<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property integer $chat_id
 * @property string $content
 * @property integer $sender
 * @property integer $created_at
 *
 * @property Chat $chat
 * @property User $sender0
 */
class Message extends \yii\db\ActiveRecord
{
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
            [['chat_id', 'user_id', 'created_at'], 'required'],
            [['chat_id', 'user_id', 'created_at'], 'integer'],
            [['content'], 'string'],
            [['chat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chat::className(), 'targetAttribute' => ['chat_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'chat_id' => Yii::t('app', 'Chat ID'),
            'content' => Yii::t('app', 'Content'),
            'user_id' => Yii::t('app', 'Sender'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChat()
    {
        return $this->hasOne(Chat::className(), ['id' => 'chat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getSender()
    {
        if(isset($this->user->params))
        {
            $rez = Html::a($this->user->username.', '.$this->user->params->age, ['site/advertiser', 'id'=>$this->user->params->id]);
        }
        else
        {
            $rez = Html::a($this->user->username, '#');
        }
        return $rez;
    }

    public function markAsRead()
    {
        if (empty($this->read_at)) {
            $this->read_at = time();
            $this->save();
        }
    }

    public static function getNewMessagesFor($userId)
    {
        $chats = Chat::getAllFor($userId);
        if (count($chats) > 0) {
            $chatsId = [];
            foreach ($chats as $chat) {
                $chatsId[] = $chat->id;
            }
            if (count($chatsId) > 0) {
                return self::find()->select('chat_id')->where(['read_at' => 0])->andWhere(['not', ['user_id' => $userId]])->andWhere(['in', 'chat_id', $chatsId])->groupBy('chat_id')->all();
            }
        }
        return false;
    }
}
