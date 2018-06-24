<?php

namespace common\components;

use yii\i18n\MissingTranslationEvent;
use yii;

class TranslationEventHandler
{
    public static function handleMissingTranslation(MissingTranslationEvent $event) {
        $res = Yii::$app->db
            ->createCommand('SELECT * FROM {{%translation}} WHERE lang_code = :lang_code AND org_text = :org_text')
           ->bindValue(':lang_code', $event->language)
           ->bindValue(':org_text', $event->message)
           ->queryOne();
// $event->translatedMessage = '#'.$event->message.'#';
        if (!$res) {
          Yii::$app->db->createCommand()->insert('{{%translation}}', [
            'category' => $event->category,
            'lang_code' => $event->language,
            'org_text' => $event->message,
            'trans_text' => ''
          ])->execute();
        }
    }
}
