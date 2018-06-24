<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Reviews */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="invoice">
    <?php $form = ActiveForm::begin(); ?>
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Review.
            <small class="pull-right">Date: <?= date('d/m/Y',$model->date_add)?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong><?= $model->idFrom->username?></strong><br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong><?= $model->idTo->username?></strong>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col  icheckbox_minimal-blue checked" aria-checked="false" aria-disabled="false">
          <?= $form->field($model, 'verify')->checkbox() ?>
        </div>
        
        

        <!-- /.col -->
      </div>
      <div class="reviews-form">
              <?= $form->field($model, 'title')->textarea(['rows' => 6]) ?>
      </div>

      <!-- /.row -->
      
          <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    </section>


