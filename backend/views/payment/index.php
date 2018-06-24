<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payments List';
$this->params['breadcrumbs'][] = $this->title;
echo Html::a('Add new payment', Url::to('/payment/create'), ['class' => 'btn btn-primary']);
?>
<div class="payments-list-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'payment_id',
            'enabled_for_payment',
            'enabled_for_payout',
            [
              'class' => 'yii\grid\ActionColumn',
              'template' => '{update} {delete}'
            ],
        ]
    ]); ?>
</div>
