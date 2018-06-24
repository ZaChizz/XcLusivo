<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 31.05.2016
 * Time: 1:31
 */
use yii\helpers\Html;
use frontend\models\AdvertiserMedia;
?>
<div class="girl <?= $model->advertiser->onlineStatus ?>"><?= Html::a('',['site/advertiser', 'id'=>$model->advertiser->id],['class'=>'cover-link'])?>
    <div class="girl-img"><?php
      $img = '';
      if (!empty($model->advertiser->images)) {
        $img = $model->advertiser->images[0];
      }
      if (!empty($img)) {
        Html::img(AdvertiserMedia::getUrl($img->getHash(), AdvertiserMedia::PREFIX_BIG_THUMB), ['alt' => $img->title]);
      }
    ?></div>
    <div class="girl-cont">
        <div class="girl-name"><?= $model->advertiser->user->username ?>, <?= $model->advertiser->age ?></div>
        <div class="girl-price"><b><?= $model->advertiser->price ?></b> €/h</div>
        <div class="girl-txt"><?= $model->advertiser->title ?>.</div>
    </div>
    <div class="bot-inf">
        <div class="date">19 Jan - 23 Jan 2015</div>
    </div>
</div>
