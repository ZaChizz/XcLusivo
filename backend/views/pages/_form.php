<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(['Disable', 'Enable']) ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_kw')->textInput(['maxlength' => true]) ?>
    <hr />
    <div class="nav-bars">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
        <?php foreach ($contents as $lang => $data) : ?>
            <li role="presentation" class="<?php echo isset($b) ? '' : 'active'; $b = true; ?>">
                <a href="#<?= $lang; ?>" aria-controls="<?= $lang; ?>" role="tab" data-toggle="tab"><?= \backend\models\Pages::getLangName($lang); ?></a>
            </li>
        <?php endforeach; ?>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <?php foreach ($contents as $lang => $data) : ?>
                <div role="tabpanel" class="tab-pane <?php echo isset($a) ? '' : 'active'; $a = true; ?>" id="<?= $lang; ?>">
                    <?= Html::label('Status', "Contents[$lang][status]", ['class'=>'control-label'])?>
                    <?= Html::dropDownList("Contents[$lang][status]", $data['status'], ['Disable', 'Enable'], ['class'=>'form-control'])?>

                    <?= Html::label('Title', "Contents[$lang][name]", ['class'=>'control-label'])?>
                    <?= Html::textInput("Contents[$lang][name]", $data['name'], ['class'=>'form-control'])?>

                    <?= Html::label('Status', "Contents[$lang][content]", ['class'=>'control-label'])?>
                    <?= Html::textarea("Contents[$lang][content]", $data['content'], ['class'=>'form-control'])?>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <?php //= $form->field($model, 'created_at')->textInput() ?>

    <?php //= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
