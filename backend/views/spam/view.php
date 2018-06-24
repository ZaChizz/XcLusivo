<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SpamReports */

$this->title = \Yii::t('app', 'Spam Report #') . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Spam Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spam-reports-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
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
            'id',
            [
                'label' => \Yii::t('app', 'From'),
                'value' => $model->type == 0 ? 'advertiser' : 'non-advertiser',
            ],
            [
                'label' => \Yii::t('app', 'Sender'),
                'value' => $model->getSender(),
            ],
            [
                'label' => \Yii::t('app', 'On whom'),
                'value' => $model->getSender(),
            ],
            'text:ntext',
            [
                'label' => \Yii::t('app', 'Created'),
                'value' => date("F j, Y, g:i a", $model->created_at),
            ],
        ],
    ]) ?>

</div>
