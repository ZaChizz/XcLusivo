<?php

namespace frontend\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "cities".
 *
 * @property integer $id
 * @property string $title
 *
 * @property Advertiser[] $advertisers
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisers()
    {
        return $this->hasMany(Advertiser::className(), ['cities_id' => 'id']);
    }

    public static function findByName($name)
    {
        return Cities::find()->where(['like', 'title', $name.'%'])->all();
    }

    public static function loadModel($arr=true)
    {
        if (($model = Cities::find()->asArray()->all()) !== null) {
            if($arr)
                return Cities::refactor2data($model);
            else
                return Cities::refactor2value($model);

        } else {
            return false;
        }
    }

    protected static function refactor2data($model)
    {
        $data = array();
        if($model)
        {
            foreach($model as $value)
            {
                $data[$value['id']] = $value['title'];
            }
            return $data;
        }
        else
            return false;
    }

    protected static function refactor2value($model)
    {
        $data = array();
        if($model)
        {
            foreach($model as $value)
            {
                $data[$value['id']] = Html::a(Yii::t('app',$value['title'],'#'));
            }
            return $data;
        }
        else
            return false;
    }
}
