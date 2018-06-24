<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 20.05.2016
 * Time: 16:50
 */

use yii\helpers\Html;

?>

<div class="pop-up" id="pop-book_req">
    <div class="pop-title"><?=Yii::t('app', 'You are about to send booking request to {username}', ['username' => 'Marianna']);?></div>
    <div class="mess-form">
        <div class="form-col">
            <div class="bal-row">
                <h4><?=Yii::t('app', 'Pay with');?></h4>
                <div class="checks">
                    <div class="check"><input type="radio" name="rad2"/><label>VISA</label></div>
                    <div class="check"><input type="radio" name="rad2"checked=""/><label>PayPal</label></div>
                    <div class="check"><input type="radio" name="rad2" /><label>Cash</label></div>
                </div>
            </div>
        </div>
        <div class="form-col">
            <div class="bal-row">
                <h4><?=Yii::t('app', 'Secure bookikng ({link})', ['link' => '<a href="#">'.Yii::t('app', 'Read more').'</a>']);?></h4>
                <div class="checks">
                    <div class="check"><input type="radio" name="rad2" value="transfer"><label class="sm"><?=Yii::t('app', 'The transfer of money <br/>to the accont of the <br/>intermediary');?></label></div>
                </div>
            </div>
        </div>
    </div>
    <div class="mess-submit">
        <a href="#" class="btn btn-gray" onclick="$.fancybox.close();"><?=Yii::t('app', 'Cancel');?></a>
        <?= Html::a(Yii::t('app', 'Confirm'),['site/make-booking-request','id'=>$model->id],['class'=>'btn']) ?>
    </div>
</div>
