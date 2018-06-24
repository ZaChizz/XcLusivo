<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 11.06.2016
 * Time: 3:23
 */

use yii\bootstrap\ActiveForm;
?>

<div class="pop-up" id="pop-reply">
    <div class="pop-title title-mess"><?= $template['title']?></div>
    <div class="mess-data"><?= $template['data']?></div>
    <?php $form = ActiveForm::begin(['id' => 'form-reply']); ?>
    <div class="mess-form">
        <label><?= $template['label']?></label>
        <?= $template['textarea']?>
    </div>
    <div class="mess-submit">
        <a href="#" class="btn btn-gray"><?=Yii::t('app', 'Cancel');?></a>
        <?= $template['submit']?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
