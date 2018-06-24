<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use app\models\Chat;

/* @var $this yii\web\View */
/* @var $model app\models\Chat */
/* @var $messages array */

$this->title = 'Chat '.$model->getUser('adv_id').' with '.$model->getUser('nadv_id');
$this->params['breadcrumbs'][] = ['label' => 'Chats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chat-view">
    <p>
        <!-- <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> -->
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // [
            //     'label' => \Yii::t('app', 'Advertiser'),
            //     'value' => $model->getUser('adv_id'),
            // ],
            // [
            //     'label' => \Yii::t('app', 'Non-advertiser'),
            //     'value' => $model->getUser('nadv_id'),
            // ],
            [
                'label' => \Yii::t('app', 'Created'),
                'value' => date("F j, Y, g:i a", $model->created_at),
            ],
        ],
    ]) ?>
    <div class="admin_message_box">
        <?php if(empty($messages)): ?>
            <p> <?= \Yii::t('app', 'There are no messages yet...') ?></p>
        <?php endif; ?>
        <?php $chatStarter = 0;?>
        <?php foreach ($messages as $m): ?>
            <?php if ($chatStarter == 0) { $chatStarter = $m->user_id; } ?>
            <fieldset class="<?= $chatStarter == $m->user_id ? 'adv-msg' : 'non-adv-msg'?>">
                <legend><?= $m->getSender();?></legend>
                <?= $m->content; ?>
                <span><?=date('Y-m-d H:i:s', $m->created_at);?></span>
            </fieldset>
        <?php endforeach; ?>
    </div>
<?php if (Chat::CHAT_WITH_ADMIN == $model->nadv_id) { ?>
    <div class="chat-form">
        <h3>Send message</h3>
        <?php $form = ActiveForm::begin(); ?>
        <?= Html::textarea('message', ''); ?>
        <div class="form-group">
            <?= Html::submitButton('Send', ['class' =>'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
<?php } ?>
</div>
