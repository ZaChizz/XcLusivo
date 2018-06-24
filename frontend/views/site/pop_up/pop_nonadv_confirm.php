<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 20.05.2016
 * Time: 17:25
 */
?>
<div class="window" style="display:block;">
    <div class="pop-title"><?=Yii::t('app', 'Congratulations, {username}! Your booking request has been confirmed by {username2}', [ 'username' => 'Alexandr', 'username2' => 'Marina']);?></div>
    <div class="fancybox-close win-close"></div>
</div>
<div class="window" style="display:block;">
    <div class="pop-title"><?=Yii::t('app', 'You just confirmed booking request <br/>from {username}', ['username' => 'Alexandr']);?></div>
    <div class="win-txt"><?=Yii::t('app', 'Date: {date}', ['date' => '12.09.2016']);?>, <?=Yii::t('app', 'Time: {time}', ['time' => '12:00 - 16:00']);?></div>
    <div class="fancybox-close win-close"></div>
</div>
