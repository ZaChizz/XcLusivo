<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = 'Oops!';
?>
<div id="content">
    <div class="cont-in">
        <div class="page404">
            <div class="title404"><?= \yii::t('app', 'Sorry. There is no such page on our website'); ?>.</div>
            <img src="<?= \yii::getAlias('@web'); ?>/images/img11.jpg" alt="" />
        </div>
    </div>
</div>