<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "services".
 *
 * @property integer $id
 * @property string $title
 */
class Services extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'services';
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

    public static function loadModels()
    {
        if (($model = Services::find()->asArray()->all()) !== null)
            return $model;
        else
            return false;
    }

    public static function arr2string($models)
    {
        if($models){
            $arr = array();
            foreach($models as $value)
            {
                $arr[]=$value['id'];
            }
            return ','.implode(",",$arr).',';
        }
        else false;

    }
}
