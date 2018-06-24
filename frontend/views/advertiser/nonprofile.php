<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 29.05.2016
 * Time: 10:17
 */

use frontend\widgets\ReviewsBar;
?>

<div class="user-col non-adv-short-info">
    <h1><?= $nadv->username ?></h1>
    <div class="user-info">
        <a href="#pop-chat" class="link-chat fancy"><?=Yii::t('app', 'My messages');?></a>
    </div>
</div>
<div class="booking-col">
  <div class="col-top">
      <?= $template['confirmLINK'] ?>
      <?= $template['refuseLINK'] ?>
  </div>
  <div class="reviews-col non-adv-short-info-reviews-col">
      <?= ReviewsBar::widget([
          'id' => $nadv->id,
          'reply'=>false
      ])
      ?>
  </div>
</div>
<div>
    <?= $this->render('chat',['model'=>$nadv,'chat'=>$chat, 'template'=>$template, 'message'=>$message]) ?>
</div>
<div style="display:none;">
    <?= $this->render('//site/pop_up/pop_confirm',['model'=>$model]) ?>
    <?= $this->render('//site/pop_up/pop_action',['model'=>$model]) ?>
</div>
