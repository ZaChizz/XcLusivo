<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 16.05.2016
 * Time: 14:48
 */

use yii\helpers\Html;
use frontend\models\AdvertiserMedia;
?>
<div class="girl <?= $model->onlineStatus ?>"><?= Html::a('',['site/advertiser', 'id'=>$model->id],['class'=>'cover-link'])?>
    <div class="girl-img">
    <?=Html::img(AdvertiserMedia::getDefaultPhotoUrl($model->user->id, AdvertiserMedia::PREFIX_BIG_THUMB));?>
    </div>
    <div class="girl-cont">
        <div class="girl-name"><?= $model->user->username ?>, <?= $model->age ?></div>
        <div class="girl-price"><b><?= $model->price ?></b> €/h</div>
        <div class="girl-txt"><?= $model->title ?></div>
    </div>
</div>
