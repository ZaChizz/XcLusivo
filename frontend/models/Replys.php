<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "replys".
 *
 * @property integer $id
 * @property integer $id_from
 * @property integer $id_review
 * @property string $title
 *
 * @property User $idFrom
 * @property Reviews $idReview
 */
class Replys extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'replys';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_from', 'id_review','title','date_add'], 'required'],
            [['id_from', 'id_review', 'date_add'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['id_from'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_from' => 'id']],
            [['id_review'], 'exist', 'skipOnError' => true, 'targetClass' => Reviews::className(), 'targetAttribute' => ['id_review' => 'id']],
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
            'id_review' => Yii::t('app', 'Id Review'),
            'title' => Yii::t('app', 'Title'),
            'date_add' => Yii::t('app', 'Date add')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdfrom()
    {
        return $this->hasOne(User::className(), ['id' => 'id_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdreview()
    {
        return $this->hasOne(Reviews::className(), ['id' => 'id_review']);
    }
}
