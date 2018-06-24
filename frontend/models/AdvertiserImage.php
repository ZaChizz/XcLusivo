<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "advetiser_image".
 *
 * @property integer $id
 * @property integer $id_advetiser
 * @property string $title
 * @property string $resolution
 * @property string $orientation
 *
 * @property Advetiser $idAdvetiser
 */
class AdvertiserImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertiser_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_advertiser', 'title', 'resolution', 'orientation'], 'required'],
            [['id_advertiser'], 'integer'],
            [['title', 'resolution', 'orientation'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_advertiser' => Yii::t('app', 'Id Advertiser'),
            'title' => Yii::t('app', 'Title'),
            'resolution' => Yii::t('app', 'Resolution'),
            'orientation' => Yii::t('app', 'Orientation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertiser()
    {
        return $this->hasOne(Advertiser::className(), ['id' => 'id_advetiser']);
    }

    public function getHash()
    {
        return md5($this->id_advertiser . '-' . $this->id);
    }

    public function getUrl($size)
    {
        return Yii::getAlias('@frontendImages/advertiser/'. $size .'/'. $this->getHash() . '.jpg');
    }


    public function getPath()
    {
        return Yii::getAlias('@images/advetiser/orig/' . $this->getHash() . '.jpg');
    }
}
