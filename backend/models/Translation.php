<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%translation}}".
 *
 * @property integer $id
 * @property string $lang_code
 * @property string $category
 * @property string $org_text
 * @property string $trans_text
 */
class Translation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%translation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang_code', 'category', 'org_text', 'trans_text'], 'required'],
            [['org_text', 'trans_text'], 'string'],
            [['lang_code'], 'string', 'max' => 5],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lang_code' => 'Lang Code',
            'category' => 'Category',
            'org_text' => 'Org Text',
            'trans_text' => 'Trans Text',
        ];
    }
}
