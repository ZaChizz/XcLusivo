<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 20.05.2016
 * Time: 17:29
 */
?>
<div style="display:none;">
    <div class="pop-up" id="pop-reply">
        <div class="pop-title title-mess"><?=Yii::t('app', 'Write a review');?></div>
        <div class="mess-data"><a href="#">Marianna</a> 12 Dec-22 Dec </div>
        <div class="mess-form">
            <label><?=Yii::t('app', 'Review text');?>:</label>
            <textarea></textarea>
        </div>
        <div class="mess-submit">
            <a href="#" class="btn btn-gray"><?=Yii::t('app', 'Cancel');?></a>
            <input type="submit" value="<?=Yii::t('app', 'Post the review');?>" class="btn"/>
        </div>
    </div>
</div>
