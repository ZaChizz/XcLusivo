<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
echo Html::a('Add new user', Url::to('/user/create'), ['class' => 'btn btn-primary']);
?>
<div class="user-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'username',
            'email:email',
            [
                'attribute'=>'type',
                'content'=>function($data){
                    return $data->type == 0 ? 'advertiser' : 'non-advertiser';
                }
            ],
            [
                'attribute'=>'status',
                'content'=>function($data){
                    return $data->getStatusName();
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
            [
              'class' => 'yii\grid\ActionColumn',
              'template' => '{ban} {view} {update} {delete}',
              'buttons' => [
                      'ban' => function ($url,$model) {
                          if ($model->status == \common\models\User::STATUS_DELETED) {
                              return Html::a('Unban', $url);
                          }
                          return Html::a('Ban', $url);
                      }
                ]
            ]
        ],
    ]); ?>

</div>
