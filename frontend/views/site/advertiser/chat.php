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
?>
<?php
$script = <<< JS
    var isAskUpdate = false;
    function tryUpdateHistory() {
      if (isAskUpdate) {
          return;
      }
      isAskUpdate = true;
      $("#linkToClick").click();
    }
    setInterval(tryUpdateHistory, 6000);
    $(document).on("pjax:success", function() {
        if (isAskUpdate) {
          isAskUpdate = false;
        } else {
          tryUpdateHistory();
        }
    });
JS;
$this->registerJs($script, View::POS_READY);
?>

<div style="position:absolute;left:0;top:-9999px;">
    <div class="pop-up pop-chat" id="pop-chat">
        <div class="pop-title"><?= $template['title']?></div>
        <div class="revs scroll">
            <?php Pjax::begin(); ?>
            <?php if ($chat) {
                foreach($chat->messages as $value): ?>
                <div class="rev">
                    <div class="rev-name"><?= $value->sender ?></div>
                    <div class="rev-txt"><?= $value->content ?></div>
                </div>
            <?php endforeach;
            } ?>
            <?= Html::a("update", ['site/advertiser', 'id'=>$model->id], ['id' =>'linkToClick', 'class'=>'btn-choose','style'=>'display:none;']);?>
            <?php Pjax::end(); ?>
        </div>
        <?php Pjax::begin(); ?>
        <?= Html::beginForm(['site/advertiser', 'id'=>$model->id], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
        <?= Html::textarea('content',$message->content)?>
        <?= Html::submitButton(Yii::t('app','Submit'), ['class' => 'btn', 'name' => 'chat-button', 'id'=>'refreshButton']) ?>
        <?= Html::endForm() ?>
        <?php Pjax::end(); ?>
    </div>
</div>
