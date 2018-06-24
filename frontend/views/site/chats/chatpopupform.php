<?php
  use yii\widgets\Pjax;
  use yii\helpers\Html;
?>
<?php Pjax::begin(); ?>
<?= Html::beginForm(['site/chat-send-message', 'id'=>$model->id], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
<?= Html::textarea('content', '', ['rows' => 2])?>
<?= Html::submitButton(Yii::t('app','Send'), ['class' => 'btn', 'name' => 'chat-button', 'id'=>'refreshButton']) ?>
<?= Html::endForm() ?>
<?php Pjax::end(); ?>
