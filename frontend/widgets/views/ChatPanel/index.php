<?php
  use yii\helpers\Html;
  use yii\web\View;

if (count($models) > 0) {
  $this->registerJs('
  var chatOffs = 1;
  $("#chatMoreList").bind("click", function(e) {
    $.get(
      "'.Yii::getAlias('@frontendWeb').'/site/chat-list",
      { "id": '.$user_id.', "offs": chatOffs  },
      function(data) {
        $("#chat-list").append(data);
        if (data === "") {
            $("#chatMoreList").hide();
        }
      }
    );
    $(this).blur();
    chatOffs++;
    e.stopPropagation();
    return false;
  });', View::POS_READY);

?>
<div class="chat-panel">
    <h2 class="link-chat"><?=Yii::t('app', 'Chats');?></h2>
    <div class="chat-list" id="chat-list">
    <?=$this->render('/site/chats/chatlist', ['models' => $models, 'isAdvertiser' => $isAdvertiser]);?>
    </div>
    <?=!empty($hasMoreChats) ? Html::a(Yii::t('app', 'Show earlier messages'), ['#'], ['class' => 'btn btn-gray', 'id' => 'chatMoreList']) : '';?>
</div>
<?php }
