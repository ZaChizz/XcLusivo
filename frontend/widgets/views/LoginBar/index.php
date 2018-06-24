<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 25.04.2016
 * Time: 21:08
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="log-drop log-drop1">
<?php $form = ActiveForm::begin(['id' => 'login-form',
    'action' => ['site/login'], 'enableAjaxValidation' => false,]); ?>
<div class="form-row signup"><?=Yii::t('app', 'Not register?');?>' <a href="#" class="head-link2"><?=Yii::t('app', 'Sign Up');?></a></div>
<div class="form-row">
    <?= $form->field($model, 'username', ['inputOptions' => ['placeholder' => Yii::t('app', 'Username'), 'class' => 't-inp']])->label(false) ?>
</div>

<div class="form-row">
    <?= $form->field($model, 'password',  ['inputOptions' => ['type' => 'password', 'placeholder' => Yii::t('app', 'Password'), 'class' => 't-inp']])->label(false) ?>
</div>
<div class="form-row">
    <?= Html::a(Yii::t('app', 'Forgot Password?'), ['site/request-password-reset']) ?>
    <div class="check"><?= $form->field($model, 'rememberMe')->checkbox() ?></div>
</div>
<div class="form-submit">
    <a href="#" class="link-cancel close-link"><?=Yii::t('app', 'Cancel');?></a>
    <?= Html::submitButton(Yii::t('app', 'Log In'), ['class' => 'btn', 'name' => 'login-button']) ?>
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
