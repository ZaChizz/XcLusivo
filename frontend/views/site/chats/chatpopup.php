<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 04.07.2016
 * Time: 21:03
 */

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;
use frontend\models\Chat;

if (empty($messagesOnly)) {
  $script = '
      function scrollToEnd() {
          var objDiv = document.getElementById("pop-chat-messages");
          objDiv.scrollTop = objDiv.scrollHeight;
      }
      function updateChatHistory() {
          $("#pop-chat-messages").load(
            "'.Url::to(['site/chat']).'?id=" + $("#chatId").val() + "&messagesOnly=1",
            scrollToEnd
          );
      }
      var updateIntervalId = updateIntervalId || setInterval(updateChatHistory, 6000);
      $(document).on("pjax:success", function() {
        updateChatHistory();
      });
      scrollToEnd();
      ';
  $this->registerJs($script, View::POS_READY);
  $isAdvertiser = \Yii::$app->user->can('advetiserProfile');
  $path = $isAdvertiser ? 'advertiser/non-advertiser-profile' : 'site/advertiser';
  $userId = $user->id != Chat::CHAT_WITH_ADMIN ? (!$isAdvertiser ? $user->params->id : $user->id) : 0;
?>
<input type="hidden" id="chatId" value="<?=$model->id;?>">
<div class="pop-up pop-chat" id="pop-chat">
    <div class="pop-title"><?=Yii::t('app', 'Chat to {username}', ['username' => $user->id != Chat::CHAT_WITH_ADMIN ? '<a href="'.Url::to([$path, 'id' => $userId]).'">'.$user->username.'</a>' : $user->username]);?></div>
    <div class="revs scroll" id="pop-chat-messages">
<?php } ?>
        <?php foreach($model->messages as $value): ?>
            <div class="rev">
                <div class="rev-name"><?= $value->sender ?><?php if ($value->user_id != Yii::$app->getUser()->id && !$value->read_at) {?><span class="chat-new"><?=Yii::t('app', 'new');?></span><?php };?></div>
                <div class="rev-txt"><?= $value->content ?></div>
            </div>
        <?php if ($value->user_id != Yii::$app->getUser()->id) {
          $value->markAsRead();
        } ?>
        <?php endforeach; ?>
<?php if (empty($messagesOnly)) { ?>
    </div>
    <?=$this->render('chatpopupform', ['model' => $model]);?>
</div>
<?php } ?>
