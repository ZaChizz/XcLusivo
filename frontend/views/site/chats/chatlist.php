<?php
  use yii\helpers\Html;
  use yii\helpers\Url;
  use frontend\models\Chat;
  use yii\web\View;

  $js = '
  function checkNewMessages() {
      $.get("'.Url::to(['site/chat-new-messages']).'", function(data) {
        $(".chat-new").hide();
        for (i in data) {
          $("#chat-" + data[i]).show();
        }
      });
      setTimeout(checkNewMessages, 10000);
  }

  checkNewMessages();
  ';
  $this->registerJs($js, View::POS_READY);

  foreach($models as $model) {
    if (count($model->messages) > 0) {
      $onlineStatus = '';
      if ($model->nadv->id == Chat::CHAT_WITH_ADMIN || $model->adv->id == Chat::CHAT_WITH_ADMIN) {
          $username = Yii::t('app', 'Admin');
      } else {
          $username = $isAdvertiser ? $model->nadv->username : $model->adv->username.', '.$model->adv->params->age;
          $onlineStatus = '';//($isAdvertiser || !$model->adv || !$model->adv->params ? '' : ($model->adv->params->online ? 'online' : 'offline'));
      }
?>

    <div class="chat-line <?=$onlineStatus;?>">
      <div class="rev-name"><?=Html::a($username, ['site/chat', 'id' => $model->id], ['class' => 'fancy fancybox.ajax', 'onClick' => 'function() { return false; }']);?> <span class="chat-new hide" id="chat-<?=$model->id;?>"><?=Yii::t('app', 'new');?></span></div>
    </div>
<?php }
  } ?>
