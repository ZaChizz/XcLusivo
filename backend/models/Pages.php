<?php

namespace backend\models;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property string $title
 * @property integer $status
 * @property string $meta_title
 * @property string $meta_desc
 * @property string $meta_kw
 * @property integer $created_at
 * @property integer $updated_at
 */
class Pages extends \yii\db\ActiveRecord
{
    public $langs = ['en', 'es', 'ge', 'no'];

    public static function getLangName($lang){
        switch ($lang){
            case 'en' :
                return \Yii::t('app', 'English');
            case 'es' :
                return \Yii::t('app', 'Spain');
            case 'ge' :
                return \Yii::t('app', 'German');
            case 'no' :
                return \Yii::t('app', 'Norway');
            default:
                return $lang;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'meta_title', 'meta_desc', 'meta_kw'], 'string', 'max' => 255],
            [['title'], 'unique']
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
            'status' => 'Status',
            'meta_title' => 'Meta Title',
            'meta_desc' => 'Meta Desc',
            'meta_kw' => 'Meta Kw',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getContent($lang = 'en'){
        $content = Page_Contents::findOne(['page_id' => $this->id, 'lang' => $lang]);

        if(!is_null($content)){
            $content = $content->content;
        } else {
            $content = '';
        }
        return $content;
    }
}
