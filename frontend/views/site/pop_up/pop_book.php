<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 20.05.2016
 * Time: 17:20
 */
?>
<div class="pop-up" id="pop-book">
    <div class="pop-title title-book"><?=Yii::t('app', 'Booking time with {username}', ['username' => 'Marianna']);?></div>
    <div class="mess-form">
        <div class="form-row">
            <label><?=Yii::t('app', 'From');?></label>
            <input type="text" class="t-inp t-inp1" value="23 Dec 2015"/>
            <input type="text" class="t-inp t-inp2" value="22:00"/>
        </div>
        <div class="form-row">
            <label><?=Yii::t('app', 'To');?></label>
            <input type="text" class="t-inp t-inp1" value="25 Dec 2015"/>
            <input type="text" class="t-inp t-inp2" value="22:00"/>
        </div>
    </div>
    <div class="mess-submit">
        <!--<input type="submit" value="Proceed to Payment" class="btn"/>-->
        <?= $template['ProceedToPaymentLINK'] ?>
    </div>
</div>
