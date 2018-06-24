<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Page', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            [
                'attribute'=>'status',
                'content'=>function($data){
                    return $data->status == 0 ? 'disabled' : 'enabled';
                }
            ],
            [
                'attribute'=>'created_at',
                'label'=>'Created',
                'format'=>'datetime',
                'headerOptions' => ['width' => '200'],
            ],
            [
                'attribute'=>'updated_at',
                'label'=>'Updated',
                'format'=>'datetime',
                'headerOptions' => ['width' => '200'],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
