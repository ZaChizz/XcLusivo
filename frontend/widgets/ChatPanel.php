<?php
namespace frontend\widgets;

use Yii;
use frontend\models\Chat;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;


class ChatPanel extends \yii\bootstrap\Widget
{
    public $user;
    public $isAdvertiser = false;

    public function run()
    {
        $models = Chat::getChatListFor(Yii::$app->getUser()->id);
        $hasMoreChats = count($models) < Chat::getChatsCountFor(Yii::$app->getUser()->id);
        return $this->render('ChatPanel/index', ['models' => $models, 'user_id' => Yii::$app->getUser()->id, 'hasMoreChats' => $hasMoreChats, 'isAdvertiser' => $this->isAdvertiser]);
    }
}
