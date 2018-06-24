<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PaymentsList */

$this->title = 'Create Payment';
$this->params['breadcrumbs'][] = ['label' => 'Payments List', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-create">
    <?= $this->render('_form', [
        'model' => $model,
        'countries' => $countries
    ]) ?>
</div>
