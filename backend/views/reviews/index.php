<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReviewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reviews');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reviews-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Reviews'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'id_from',
                'content'=>function($data){
                    return $data->idFrom->username;
                }
            ],
            [
                'attribute'=>'id_to',
                'content'=>function($data){
                    return $data->idTo->username;
                }
            ],
            'title:ntext',
            [
                'attribute'=>'verify',
                'content'=>function($data){
                    if($data->verify == 0)
                        return '<span class="pull-right-container"><small class="label pull-right bg-red">Verify</small></span>';
                    else
                        return '<span class="pull-right-container"><small class="label pull-right bg-green">Verified</small></span>';
                        
                }
            ],
            [
                'attribute'=>'date_add',
                'label'=>'date_add',
                'format'=>'datetime',
                'headerOptions' => ['width' => '200'],
            ],

            [
              'class' => 'yii\grid\ActionColumn',
              'template' => '{update} {delete}',
              'headerOptions' => ['width' => '50'],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
