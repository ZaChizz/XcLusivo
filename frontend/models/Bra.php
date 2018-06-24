<?php

namespace frontend\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "bra".
 *
 * @property integer $id
 * @property string $title
 *
 * @property Advertiser[] $advertisers
 */
class Bra extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bra';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['group'], 'in', 'range' => array('small','medium','big')],
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
            'group' => Yii::t('app', 'Group'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisers()
    {
        return $this->hasMany(Advertiser::className(), ['bra_id' => 'id']);
    }

    public static function loadModel()
    {
        if (($model = Bra::find()->asArray()->all()) !== null)
            return Bra::refactor2data($model);
        else
            return false;

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

    public static function getGroups()
    {
        $ret = array();
        $data = self::find()->asArray()->all();
        if ($data) {
            foreach ($data as $row) {
                if (!isset($ret[$row['group']])) {
                    $ret[$row['group']] = array();
                }
                $ret[$row['group']][] = $row['id'];
            }
            $tmp = array();
            foreach ($ret as $group => $ids) {
                $tmp[implode(',', $ids)] = ucfirst($group);
            }
            $ret = $tmp;
        }
        return $ret;
    }
}
