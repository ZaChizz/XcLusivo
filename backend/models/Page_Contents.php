<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "page_contents".
 *
 * @property integer $id
 * @property integer $page_id
 * @property string $lang
 * @property string $name
 * @property string $content
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Page_Contents extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_contents';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'lang', 'created_at', 'updated_at'], 'required'],
            [['page_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['lang', 'name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'lang' => 'Lang',
            'name' => 'Name',
            'content' => 'Content',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
