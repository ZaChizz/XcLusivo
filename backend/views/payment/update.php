<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Chat */

$this->title = 'Update Payment: ' . ' ' . $model->payment_id;
$this->params['breadcrumbs'][] = ['label' => 'Payments List', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->payment_id, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payment-update">

    <?= $this->render('_form', [
        'model' => $model,
        'countries' => $countries
    ]) ?>

</div>
