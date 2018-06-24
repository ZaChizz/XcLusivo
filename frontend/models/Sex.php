<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%sex}}".
 *
 * @property integer $id
 * @property string $title
 */
class Sex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sex}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 20],
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

    public static function asArray()
    {
      $res = [];
      $model = self::find()->all();
      if ($model) {
        foreach ($model as $item) {
          $res[$item->id] = $item->title;
        }
      }
      return $res;
    }
}
