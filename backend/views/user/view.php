<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->username;
?>
<div class="user-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'username',
            'email:email',
            'phone',
            [
                'label' => \Yii::t('app', 'Type'),
                'value' => $model->type == 0 ? 'advertiser' : 'non-advertiser',
            ],
            [
                'label' => \Yii::t('app', 'Status'),
                'value' => $model->getStatusName(),
            ],
            [
                'label' => \Yii::t('app', 'Created'),
                'value' => date("F j, Y, g:i a", $model->created_at),
            ],
            [
                'label' => \Yii::t('app', 'Updated'),
                'value' => date("F j, Y, g:i a", $model->updated_at),
            ],
        ],
    ]) ?>

</div>
