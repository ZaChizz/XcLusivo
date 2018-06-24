<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property integer $id
 * @property string $pay_account
 * @property string $meta_title
 * @property string $admin_email
 * @property integer $percent
 * @property integer $updated_at
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['percent', 'updated_at'], 'integer'],
            [['updated_at'], 'required'],
            [['pay_account', 'meta_title', 'admin_email'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pay_account' => 'Pay Account',
            'meta_title' => 'Meta Title',
            'admin_email' => 'Admin Email',
            'percent' => 'Percent',
            'updated_at' => 'Updated At',
        ];
    }
}
