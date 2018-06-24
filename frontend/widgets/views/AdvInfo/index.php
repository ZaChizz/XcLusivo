<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 29.04.2016
 * Time: 17:02
 */

 use frontend\widgets\ChatPanel;
 use yii\helpers\Html;
 use frontend\models\Advertiser;
 use yii\web\View;


 $js ='
 $(".switch-state").click(function() {
   var btn = $(this);
   var val = 0;
   btn.hide();
   if (btn.hasClass("stat-red")) {
     $(".stat-green").show();
     val = $(".stat-green").attr("data-value");
   } else {
     $(".stat-red").show();
     val = $(".stat-red").attr("data-value");
   }
   $.post("#", {"hasEditable":1, "_csrf":"'.\Yii::$app->request->csrfToken.'", "Advertiser":{"online":val}});
   $(".manual-state").val(val);
 });
 ';

 $this->registerJs($js, View::POS_READY);
?>

<div class="user-info">
    <h1 class="field-name"><?=('/advertiser/advertiser-profile' != \Yii::$app->request->getUrl() ? Html::a(Yii::t('app', 'My profile'), ['advertiser/advertiser-profile']) : Yii::t('app', 'My profile'));?></h1>
    <div class="filt-hid">
      <form>
        <ul>
            <li>
              <div class="phone editable<?= empty($model->phone) ? ' required' : ''; ?>" data-name="phone" data-placeholder="<?=Yii::t('app', 'your number');?>" data-title="<?=Yii::t('app', 'Phone number should only contain digits, spaces, - and +. Like +0123-456-7890');?>" data-pattern="^\+?(?:\(\d{3}\)|\d{3,4})[- ]?\d{3,4}[- ]?\d{4}$" data-origin="<?= $model->phone ?>"><?= $model->phone ?>&nbsp;</div>
              <a href="#" class="link-edit editable" data-edit-name="phone"></a>
            </li>
            <li>
              <a href="#pop-upload" class="link-photo fancy"><?=Yii::t('app', 'Upload photos');?></a>
            </li>
            <li>
              <div class="pause-check">
                <div class="check">
                  <input type="checkbox" class="editable" name="pause" value="1"<?=$advertiser->pause ? ' checked="checked"' : '';?>>
                </div>
                <?=Yii::t('app', 'Pause ad');?>
              </div>
            </li>
            <li class="active">
              <a href="#" class="link-book opener"><?=Yii::t('app', 'My bookings');?></a>
              <?= $this->render('booking_index',[
                                  'booking'=>$booking,
                                  'reviews'=>$reviews,
                                  'bqPending' => $bqPending,
                                  'bqActive' => $bqActive,
                                  'bqPast'=>$bqPast,
                                  ]); ?>
            </li>
<?php /*
            <li><a href="#" class="paym opener"><?=Yii::t('app', 'Payment methods');?></a>
                <div class="info-drop">
                    <div class="checks">
                      <?php
                        if (isset($payments)) {
                          foreach ($payments as $payment) {
                          ?>
                          <div class="check">
                              <label>
                                <input type="radio" name="payment_id" value="<?=$payment['payment_id'];?>"<?=($advPayment == $payment['payment_id'] ? ' checked="checked"' : '');?> class="editable">
                                <?=Yii::t('app', $payment['payment_id']);?>
                              </label>
                          </div>
                          <?php
                          }
                        }
                      ?>
                    </div>
                </div>
            </li>
            */ ?>
            <li class="active">
                <a href="#" class="opener"><?=Yii::t('app', 'Free/busy indication');?></a>
                <div class="info-drop">
                    <div class="checks">
                        <div class="check">
                            <label>
                              <input type="radio" name="online" class="editable" value="<?=Advertiser::ONLINE_BASED_ON_BOOKING;?>"<?=$advertiser->isOnlineBasedOnBooking() ? ' checked="checked"' : '';?>>
                              <?=Yii::t('app', 'Based on booking');?>
                            </label>
                        </div>
                        <div class="check">
                          <button data-value="<?=Advertiser::ONLINE_MANUAL_OFFLINE;?>" class="switch-state stat-red<?=$advertiser->online != Advertiser::ONLINE_MANUAL_OFFLINE ? ' hidden' : '';?>"><?=Yii::t('app', 'Offline');?></button>
                          <button data-value="<?=Advertiser::ONLINE_MANUAL_ONLINE;?>" class="switch-state stat-green<?=$advertiser->online == Advertiser::ONLINE_MANUAL_OFFLINE ? ' hidden' : '';?>"><?=Yii::t('app', 'Online');?></button>
                          <label>
                            <input type="radio"  name="online" class="editable manual-state" value="<?=Advertiser::ONLINE_MANUAL_ONLINE;?>"<?=$advertiser->isOnlineManual() ? ' checked="checked"' : '';?>>
                            <?=Yii::t('app', 'Manual');?>
                          </label>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
      </form>
    </div>
    <div class="cover2"></div>
    <?=ChatPanel::widget([
        'user' => Yii::$app->getUser(),
        'isAdvertiser' => true
    ]); ?>
</div>
