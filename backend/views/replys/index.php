<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReplysSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Replys');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="replys-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
            'id_review',
            'title:ntext',
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
