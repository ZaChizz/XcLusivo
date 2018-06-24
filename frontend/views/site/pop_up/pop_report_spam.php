<?php
use yii\web\View;
use yii\helpers\Html;

$script = '
$("#report-spam-form").submit(function(event) {
  $.post("/site/report-spam",
        $("#report-spam-form").serialize(),
        function () {
          $.fancybox.close();
          $.fancybox(\'<div class="pop-up pop-report-sent"><div class="pop-title">'.Yii::t('app', 'Report spam').'</div><p>'.Yii::t('app', 'Report is sent').'</p></div>\');
        });
  event.preventDefault();
});
';
$this->registerJs($script, View::POS_READY);
?>
<div style="position:absolute;left:0;top:-9999px;">
    <div class="pop-up pop-report-spam" id="pop-report-spam">
        <div class="pop-title"><?=Yii::t('app', 'Report spam');?></div>
        <?= Html::beginForm(['site/report-spam'], 'post', ['id' => 'report-spam-form', 'class' => 'form-inline']); ?>
        <?= Html::textarea('report')?>
        <?= Html::submitButton(Yii::t('app','Submit'), ['class' => 'btn', 'name' => 'chat-button', 'id'=>'reportBtn']) ?>
        <?= Html::hiddenInput('advId', $model->id);?>
        <?= Html::endForm() ?>
    </div>
</div>
<a href="#pop-report-spam" class="link-spam fancy"><?=Yii::t('app', 'Report spam');?></a>
