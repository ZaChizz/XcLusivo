<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "colors".
 *
 * @property integer $id
 * @property integer $type
 * @property string $title
 * @property string $class
 *
 * @property Advertiser[] $advertisers
 * @property Advertiser[] $advertisers0
 * @property Advertiser[] $advertisers1
 */
class Colors extends \yii\db\ActiveRecord
{

    const TYPE_HAIR = 1;
    const TYPE_EYE = 2;
    const TYPE_SKIN = 3;

    public $models = array();
    public $hair = array();
    public $eye = array();
    public $skin = array();


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'colors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'title', 'class'], 'required'],
            [['type'], 'integer'],
            [['title', 'class'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'title' => Yii::t('app', 'Title'),
            'class' => Yii::t('app', 'Class'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisersHair()
    {
        return $this->hasMany(Advertiser::className(), ['hair_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisersEye()
    {
        return $this->hasMany(Advertiser::className(), ['eye_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisersSkin()
    {
        return $this->hasMany(Advertiser::className(), ['skin_id' => 'id']);
    }

    public function loadModels()
    {
        $this->models = Colors::find()->asArray()->all();
        foreach($this->models as $model)
        {
            if($model['type'] == Colors::TYPE_HAIR)
                $this->hair[$model['id']] = ['name' => $model['title'], 'class' => $model['class']];
            elseif($model['type'] == Colors::TYPE_EYE)
                $this->eye[$model['id']] = ['name' => $model['title'], 'class' => $model['class']];
            elseif($model['type'] == Colors::TYPE_SKIN)
                $this->skin[$model['id']] = ['name' => $model['title'], 'class' => $model['class']];
        }

    }

}
