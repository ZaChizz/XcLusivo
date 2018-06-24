<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\controllers\PaymentHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment History';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-history-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'created_at',
            'updated_at',
            'payer_id',
            'receiver_id',
            'amount',
            'currency',
            'status',
            'payment_id',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
