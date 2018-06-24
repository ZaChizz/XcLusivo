<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 04.07.2016
 * Time: 21:01
 */

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\web\View;

?>

<div style="position:absolute;left:0;top:-9999px;">
    <div class="pop-up pop-chat" id="pop-chat">
        <div class="pop-title"><?= $template['title']?></div>
        <div class="revs scroll">
            <?php Pjax::begin(); ?>
            <?php foreach($chat->messages as $value): ?>
                <div class="rev" data-id="<?=$value->id;?>">
                    <div class="rev-name"><?= $value->sender ?><?php if (!$value->read_at) {?><span class="chat-new"><?=Yii::t('app', 'new');?></span><?php };?></div>
                    <div class="rev-txt"><?= $value->content ?></div>
                </div>
            <?php endforeach; ?>
            <?= Html::a("update", ['advertiser/non-advertiser-profile', 'id'=>$model->id], ['id' =>'linkToClick', 'class'=>'btn-choose','style'=>'display:none;']);?>
            <?php Pjax::end(); ?>
        </div>
        <?php Pjax::begin(); ?>
        <?= Html::beginForm(['advertiser/non-advertiser-profile', 'id'=>$model->id], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
        <?= Html::textarea('content',$message->content)?>
        <?= Html::submitButton(Yii::t('app','Submit'), ['class' => 'btn', 'name' => 'chat-button', 'id'=>'refreshButton']) ?>
        <?= Html::endForm() ?>
        <?php Pjax::end(); ?>
    </div>
</div>
<?php
    $script = <<< JS
    setInterval(function(){ $("#linkToClick").click(); }, 2000);
JS;
        $this->registerJs($script, View::POS_READY);
