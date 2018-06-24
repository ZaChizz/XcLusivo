<?php
  use frontend\widgets\ChatPanel;
  use yii\helpers\Html;
  use frontend\models\Chat;

  $this->registerJsFile(Yii::getAlias('@frontendWeb') . '/js/jquery.editable.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
  $this->registerJs('$(".editable").editable("' . \Yii::$app->request->csrfToken . '", "NonAdvertiser");', yii\web\View::POS_READY);
?>

<div class="user-info non-adv-widget">
    <h1>
    <?php if ($isOwn) : ?>
    <?=Yii::t('app', 'My profile');?>
    <?php else : ?>
    <?= $model->username; ?>
    <?php endif; ?>
    </h1>
    <div class="filt-hid">
        <form>
            <ul>
                <li>
                   <div class="phone editable<?= empty($model->phone) ? ' required' : ''; ?>" data-placeholder="<?=Yii::t('app', 'your number');?>" data-title="<?=Yii::t('app', 'Phone number should only contain digits, spaces, - and +. Like +0123-456-7890');?>" data-pattern="^\+?(?:\(\d{3}\)|\d{3,4})[- ]?\d{3,4}[- ]?\d{4}$" data-name="phone" data-origin="<?= $model->phone ?>"><?= $model->phone; ?>&nbsp;</div>
                  <a href="#" class="link-edit editable" data-edit-name="phone"></a>
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
                                    <input type="radio" name="payment_id" value="<?=$payment['payment_id'];?>" class="editable">
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
            </ul>
        </form>
    </div>
<?=ChatPanel::widget(['user' => $model]);?>
<div class="sett-subm">
    <?=Html::a(Yii::t('app', 'Start chat with Admin'), ['site/chat', 'id' => Chat::getChatWithAdmin($model->id)->id], ['class' => 'fancy fancybox.ajax', 'onClick' => 'function() { return false; }']);?>
</div>
    <div class="cover2"></div>
</div>
