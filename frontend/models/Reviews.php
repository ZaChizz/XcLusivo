<?php

namespace frontend\models;

use Yii;

use common\models\User;
use yii\db\ActiveRecord;
use common\helpers\Scoring;
use common\helpers\Toolbox;

/**
 * This is the model class for table "reviews".
 *
 * @property integer $id
 * @property integer $id_from
 * @property integer $id_to
 * @property string $title
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
        return '{{%reviews}}';
    }

	
	public function behaviors()
	{
		return [
//			\common\behaviors\ExtractErrorBehavior::className(),
			'timestamp' => [
				'class' => 'yii\behaviors\TimestampBehavior',
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['date_add'],
				],
			],
		];
	}
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_from', 'id_to'], 'required'],
            [['id_from', 'id_to'], 'integer'],
            [['title'], 'safe'],
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
            'date_add' => Yii::t('app', 'Date add')
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
    public function getIdfrom()
    {
        return $this->hasOne(User::className(), ['id' => 'id_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdto()
    {
        return $this->hasOne(User::className(), ['id' => 'id_to']);
    }

    public static function loadModelFrom($id)
    {
        if (($model = Reviews::find()->where(['id_from' => $id])->all()) !== null) {
            return $model;
        } else {
            return false;
        }
    }

    public static function loadModelTo($id)
    {
        if (($model = Reviews::find()->where(['id_to' => $id])->all()) !== null) {
            return $model;
        } else {
            return false;
        }
    }

	
	public function afterSave($insert, $changedAttributes)
	{
		if ($insert && Toolbox::currentNonAdvertiser()) {
			$userTo = User::find()->joinWith(['params'])->where(['user.id' => $this->id_to])->one();
			
			if ($userTo && $userTo->params && (Toolbox::currentNonAdvertiser()->id == $this->id_from)) {
				Scoring::add($userTo->id, 5, 20, $this, $this->id_from);
			}
		}
		
		return parent::afterSave($insert, $changedAttributes);
	}

}
