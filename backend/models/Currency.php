<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%currency}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $symbol_left
 * @property string $symbol_right
 * @property double $value
 * @property integer $status
 * @property string $date_modified
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%currency}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['date_modified'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['date_modified'],
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
            [['code', 'value', 'status'], 'required'],
            [['value'], 'number'],
            [['status'], 'integer'],
            [['date_modified'], 'safe'],
            [['code'], 'string', 'max' => 3],
            [['symbol_left', 'symbol_right'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'symbol_left' => 'Symbol Left',
            'symbol_right' => 'Symbol Right',
            'value' => 'Value',
            'status' => 'Status',
            'date_modified' => 'Date Modified',
        ];
    }
}
