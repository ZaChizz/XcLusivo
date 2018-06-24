<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?php if (!empty($isCreate)) { ?>
    <?= $form->field($model, 'password')->textInput() ?>
    <?php } ?>
    <?= $form->field($model, 'status')->dropDownList([
      \common\models\User::STATUS_DELETED => 'not active (banned)',
      \common\models\User::STATUS_ACTIVE => 'active',
      \common\models\User::STATUS_AGE_BLOCKED => 'lock by age',
      \common\models\User::STATUS_PAUSE => 'on pause'
    ]) ?>
    <?= $form->field($model, 'type')->dropDownList(['advertiser', 'non-advertiser']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
