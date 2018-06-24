<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 30.05.2016
 * Time: 10:14
 */

use yii\helpers\Html;

?>
<div class="pop-up pop-action" id="pop-action">
    <div class="pop-title"><?=Yii::t('app', 'Are you sure you want to refuse booking from {username}?', ['username' => $model->nonadvertiser->username]);?></div>
    <div class="mess-submit">
        <?= Html::a(yii::t('app', 'Yes'),['advertiser/refuse-booking-request','id'=>$model->id],['class'=>'btn btn-gray']) ?>
        <a href="#" class="btn" onclick="$.fancybox.close();">No</a>
        <div class="check">
            <input type="checkbox" checked=""/>
            <label><?=Yii::t('app', 'Don\'t show this message again');?></label>
        </div>
    </div>
</div>
