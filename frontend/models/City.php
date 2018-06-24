<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 15.07.2016
 * Time: 3:02
 */

namespace frontend\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property integer $id_country
 * @property string $title
 * @property double $latitude
 * @property double $longitude
 * @property double $altitude
 *
 * @property Advertiser[] $advertisers
 * @property Country $idCountry
 */
class City extends \yii\db\ActiveRecord
{

    public $country_title;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%city}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_country'], 'required'],
            [['id_country'], 'integer'],
            [['latitude', 'longitude', 'altitude'], 'number'],
            [['title'], 'string', 'max' => 255],
            [['id_country'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['id_country' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_country' => Yii::t('app', 'Id Country'),
            'title' => Yii::t('app', 'Title'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'altitude' => Yii::t('app', 'Altitude'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisers()
    {
        return $this->hasMany(Advertiser::className(), ['cities_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'id_country']);
    }

    public static function findByName($name)
    {
        return City::find()->where(['like', 'title', $name.'%', false])->all();
    }

    public static function loadModel($arr=true)
    {
        if (($model = City::find()->asArray()->all()) !== null) {
            $country = Country::loadModel();
            if($arr)
                return City::refactor2data($model,$country);
            else
                return City::refactor2value($model,$country);

        } else {
            return false;
        }
    }

    protected static function refactor2data($model,$relation)
    {
        $data = array();
        if($model)
        {
            foreach($model as $value)
            {
                $data[$value['id']] = $value['title'].', '.$relation[$value['id_country']];
            }
            return $data;
        }
        else
            return false;
    }

    protected static function refactor2value($model,$relation)
    {
        $data = array();
        if($model)
        {
            foreach($model as $value)
            {
                $data[$value['id']] = Html::a(Yii::t('app',$value['title']).', '.Yii::t('app', $relation[$value['id_country']]), '#');
            }
            return $data;
        }
        else
            return false;
    }

    public static function loadCountryId($id)
    {
        if (($model = City::findOne($id)) !== null) {
            return $model->id_country;
        }
        else
            return false;
    }

}
