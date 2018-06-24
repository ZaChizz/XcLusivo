<?php

namespace frontend\models;

use Yii;

use yii\helpers\Html;
/**
 * This is the model class for table "nationality".
 *
 * @property integer $id
 * @property string $title
 *
 * @property Advertiser[] $advertisers
 */
class Nationality extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nationality';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
        return $this->hasMany(Advertiser::className(), ['nationality_id' => 'id']);
    }

    public static function loadModel($arr=true)
    {
        if (($model = Nationality::find()->asArray()->all()) !== null) {
            if($arr)
                return Nationality::refactor2data($model);
            else
                return Nationality::refactor2value($model);

        } else {
            return false;
        }
    }

    protected static function refactor2data($model)
    {
        $data = array();
        if ($model) {
            foreach($model as $value) {
                $data[$value['id']] = Yii::t('app', $value['title']);
            }
            return $data;
        } else {
            return false;
        }
    }

    protected static function refactor2value($model)
    {
        $data = array();
        if ($model) {
            foreach ($model as $value) {
                $data[$value['id']] = '<div class="filter-value">'.Yii::t('app', $value['title']).'</div>';
            }
            return $data;
        } else {
            return false;
        }
    }
}
