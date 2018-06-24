<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Country;

/* @var $this yii\web\View */
/* @var $model app\models\PaymentsList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'payment_id')->textInput() ?>

    <?= $form->field($model, 'enabled_for_payment')->checkbox() ?>

    <?= $form->field($model, 'enabled_for_payout')->checkbox() ?>

    <?= Html::listBox('PaymentsCountry[country_id]', $countries, Country::loadModel(), ['multiple' => 'true']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
