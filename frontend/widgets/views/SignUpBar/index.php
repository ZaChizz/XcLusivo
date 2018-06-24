<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 26.04.2016
 * Time: 12:10
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="log-drop log-drop2">

    <?php $form = ActiveForm::begin(['action' => ['site/signup', 'enableAjaxValidation' => false]]); ?>


<div class="form-row">
    <?= $form->field($model, 'username', ['inputOptions' => ['placeholder' => Yii::t('app', 'Name'), 'class' => 't-inp']])->label(false); ?>
</div>

<div class="form-row">
    <?= $form->field($model, 'email', ['inputOptions' => ['type' => 'email', 'placeholder' => Yii::t('app', 'Email'), 'class' => 't-inp']])->label(false); ?>
</div>

<div class="form-row">
    <?= $form->field($model, 'password', ['inputOptions' => ['type' => 'password', 'placeholder' => Yii::t('app', 'Password'), 'class' => 't-inp']])->label(false);?>
</div>

<div class="form-row">
    <div class="check">
        <label><?= $form->field($model, 'nonAdv')->checkbox()->label(false) ?>
        <?= \yii::t('app', 'I\'m not advertiser') ?></label>
    </div>
    <div class="check">
        <label><input type="checkbox"/><?= \yii::t('app', 'Remember Me') ?></label>
    </div>
</div>

<div class="form-submit">
    <a href="#" class="link-cancel close-link"><?=Yii::t('app', 'Cancel');?></a>
    <?= Html::submitButton(Yii::t('app', 'Sign Up'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
</div>

<?php ActiveForm::end(); ?>

<div class="sm-title"><span><?=Yii::t('app', 'or connect with');?></span></div>
<!--
<div class="form-submit">
    <a href="#" class="btn btn-blue" onclick="alert('Coming Soon...')" >Facebook</a>
    <a href="#" class="btn btn-red" onclick="alert('Coming Soon...')" >Google +</a>
</div>
-->
    <?php echo \nodge\eauth\Widget::widget(array('action' => 'site/login')); ?>
</div>
