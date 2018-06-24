<?php

namespace backend\models;
use common\models\User;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property integer $id
 * @property integer $id_from
 * @property integer $id_to
 * @property string $title
 * @property integer $verify
 * @property integer $date_add
 *
 * @property Replys[] $replys
 * @property User $idFrom
 * @property User $idTo
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_from', 'id_to', 'title', 'date_add'], 'required'],
            [['id_from', 'id_to', 'verify', 'date_add'], 'integer'],
            [['title'], 'string'],
            [['id_from'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_from' => 'id']],
            [['id_to'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_to' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_from' => Yii::t('app', 'Id From'),
            'id_to' => Yii::t('app', 'Id To'),
            'title' => Yii::t('app', 'Title'),
            'verify' => Yii::t('app', 'Verify'),
            'date_add' => Yii::t('app', 'Date Add'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplys()
    {
        return $this->hasMany(Replys::className(), ['id_review' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'id_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTo()
    {
        return $this->hasOne(User::className(), ['id' => 'id_to']);
    }
}
