<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 17.05.2016
 * Time: 1:41
 */
 use yii\helpers\Html;
 use frontend\models\AdvertiserMedia;
?>

<h2><?=Yii::t('app', 'Favorite Profiles');?></h2>
<div class="fav-slider">
<?php if ($model) {
    foreach ($model as $item) { ?>
    <div class="girl <?=$item->advertiser->onlineStatus;?> gfav">
        <?= Html::a('',['site/advertiser', 'id'=>$item->advertiser->id],['class'=>'cover-link'])?>
        <div class="girl-img">
          <?=Html::img(AdvertiserMedia::getDefaultPhotoUrl($item->advertiser->user_id, AdvertiserMedia::PREFIX_BIG_THUMB));?>
          <a href="#" class="fav on"></a>
        </div>
        <div class="girl-cont">
            <div class="girl-name"><?=$item->advertiser->username;?>, <?=$item->advertiser->age;?></div>
            <div class="girl-price"><b><?=$item->advertiser->price;?></b> €/h</div>
            <div class="girl-txt"><?=$item->advertiser->title;?></div>
        </div>
    </div>
<?php }
  } ?>
</div>
