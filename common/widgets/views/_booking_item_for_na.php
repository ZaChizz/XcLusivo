<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 31.05.2016
 * Time: 1:31
 */
use yii\helpers\Html;
use common\helpers\Toolbox;
use frontend\models\AdvertiserMedia;
if ($model->advertiser) {
?>
<div class="girl <?= $model->advertiser->onlineStatus ?>"><?= Html::a('',['site/advertiser', 'id'=>$model->advertiser->id],['class'=>'cover-link'])?>
    <div class="girl-img"><?= Html::img(AdvertiserMedia::getDefaultPhotoUrl($model->advertiser->user_id, AdvertiserMedia::PREFIX_BIG_THUMB)); ?></div>
    <div class="girl-cont">
        <div class="girl-name"><?= $model->advertiser->user->username ?>, <?= $model->advertiser->age ?></div>
        <div class="girl-price"><b><?= $model->advertiser->price ?></b> €/h</div>
        <div class="girl-txt"><?= $model->advertiser->title ?>.</div>
    </div>
    <div class="bot-inf">
        <div class="date"><?=Yii::$app->formatter->asDatetime($model->from_date).' - '.Yii::$app->formatter->asDatetime($model->to_date); ?></div>
    </div>
</div>
<?php }
