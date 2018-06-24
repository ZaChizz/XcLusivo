<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 31.05.2016
 * Time: 0:44
 */

use yii\helpers\Html;
?>
<div class="girl <?= $model->advertiser->onlineStatus ?>"><?= Html::a('',['site/advertiser', 'id'=>$model->advertiser->id],['class'=>'cover-link'])?>
    <div class="girl-img"><?= Html::img(Yii::getAlias('@frontendImages/advertiser/220x220/').$model->advertiser->images[0]->getHash().'.jpg', ['alt' => $model->advertiser->images[0]->title]) ?></div>
    <div class="girl-cont">
        <div class="girl-name"><?= $model->advertiser->user->username ?>, <?= $model->advertiser->age ?></div>
        <div class="girl-price"><b><?= $model->advertiser->price ?></b> €/h</div>
        <div class="girl-txt"><?= $model->advertiser->title ?>.</div>
    </div>
    <div class="bot-inf">
        <div class="date">19 Jan - 23 Jan 2015</div>
        <?= Html::a(Yii::t('app','Write a review'),['non-advertiser/review', 'id'=>$model->advertiser->user->id],['class'=>'fancy fancybox.ajax']); ?>
    </div>
</div>