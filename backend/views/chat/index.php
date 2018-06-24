<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chat-index">
    <p>
        <!-- <?= Html::a('Create Chat', ['create'], ['class' => 'btn btn-success']) ?> -->
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute'=>'adv_id',
                'content'=>function($data){
                    return $data->getUser('adv_id');
                }
            ],
            [
                'attribute'=>'nadv_id',
                'content'=>function($data){
                    return $data->getUser('nadv_id');
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
                'content' => function($data) {
                  return Yii::$app->formatter->asDatetime($data->updated_at).($data->hasNewMessages() ? '<span class="chat-new">new</span>' : '');
                },
                'headerOptions' => ['width' => '200'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url,$model) {
                        return Html::a('Read chat', $url);
                    },
                ]
            ],
        ],
    ]); ?>

</div>
