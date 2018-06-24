<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 29.05.2016
 * Time: 7:42
 */

use yii\helpers\Html;

?>

<div class="book-prev">
    <?= Html::a($model->nonadvertiser->username,['advertiser/non-advertiser-profile','id'=>$model->nonadvertiser->id],['class'=>'b-name'])?><br/>12 Feb 22:00 - 14 Feb 22:00
    <div class="reply"><?= isset($reviews[$model->nonadvertiser->id])?Yii::t('app','Review written on {username}', ['username' => $reviews[$model->nonadvertiser->id]]) : Html::a(Yii::t('app','Write a review'), ['advertiser/review', 'id'=>$model->nonadvertiser->id], ['class'=>'fancy fancybox.ajax']); ?></div>

</div>
