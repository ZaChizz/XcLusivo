<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Spam Reports';
$this->params['breadcrumbs'][] = $this->title;
define('SPAM_LAST_VIEW', $last_view);
?>
<div class="spam-reports-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute'=>'type',
                'content'=>function($data){
                    return $data->type == 0 ? 'advertiser' : 'non-advertiser';
                }
            ],
            [
                'attribute'=>'sender_id',
                'content'=>function($data){
                    return '<a href="/user/view?id='.$data->sender_id.'">'.$data->getSender().'</a>';
                }
            ],
            [
                'attribute'=>'on_whom',
                'content'=>function($data){
                    return '<a href="/user/view?id='.$data->on_whom.'">'.$data->getOnWhom().'</a>';
                }
            ],
            'text:ntext',
            [
                'attribute'=>'created_at',
                'label'=>'Created',
                'format'=>'datetime',
                'content' => function($data) {
                  return $data->created_at.(SPAM_LAST_VIEW < $data->created_at ? '<span class="spam-new">new</span>' : '');
                },
                'headerOptions' => ['width' => '200'],
            ],
            //['class' => 'yii\grid\ActionColumn', 'template' => '{view} {delete}'],
        ],
    ]); ?>

</div>
