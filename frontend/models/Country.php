<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 15.07.2016
 * Time: 3:03
 */

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property string $title
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
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
            'id' => 'ID',
            'title' => 'Title',
        ];
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

    public static function loadModel($arr=true)
    {
        if (($model = Country::find()->orderBy('title')->asArray()->all()) !== null) {
            return Country::refactor2data($model);

        } else {
            return false;
        }
    }
}
