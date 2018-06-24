<?php
  namespace common\helpers;

  class Email
  {
    /**
     * Send Email
     * @param string $to
     * @param string $viewFile
     * @param array $params
     * @param string $from
     */
    public static function send($to, $viewFile, $params = [], $from = null)
    {
        if (empty($to)) {
          throw new Exception('"To" is empty');
        }
        if (empty($viewFile)) {
          throw new Exception('Mail template (viewFile) is empty');
        }
        if ($from == null) {
          $from = \Yii::$app->params['adminEmail'];
        }
        $mailer = \Yii::$app->mailer;
        $lang = \Yii::$app->language;
        $viewHtml = 'html/'.$viewFile;
        $viewText = 'text/'.$viewFile;
        if ($lang != 'en' && file_exists(__DIR__.'/../mail/'.$viewHtml.'_'.$lang.'.php')) {
          $viewHtml = $viewHtml.'_'.$lang;
        }
        if ($lang != 'en' && file_exists(__DIR__.'/../mail/'.$viewText.'_'.$lang.'.php')) {
          $viewText = $viewText.'_'.$lang;
        }
        echo $viewHtml;
        $message = $mailer->compose([
                          'html' => $viewHtml,
                          'text' => $viewText,
                          ], $params)
                ->setFrom($from)
                ->setTo($to);
        if (isset($params['subject'])) {
          $message->setSubject($params['subject']);
        }
        return $message->send();
    }
  }
