<?php

namespace backend\models;

use common\models\User;

use Yii;

/**
 * This is the model class for table "replys".
 *
 * @property integer $id
 * @property integer $id_from
 * @property integer $id_review
 * @property string $title
 * @property integer $verify
 * @property integer $date_add
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
            [['id_from', 'id_review', 'title', 'date_add'], 'required'],
            [['id_from', 'id_review', 'date_add'], 'integer'],
            [['title'], 'string'],
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
            'date_add' => Yii::t('app', 'Date Add'),
        ];
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
    public function getIdReview()
    {
        return $this->hasOne(Reviews::className(), ['id' => 'id_review']);
    }
}
