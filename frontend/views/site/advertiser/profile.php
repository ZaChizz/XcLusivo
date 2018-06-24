<?php

/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 17.05.2016
 * Time: 1:38
 */
use yii\helpers\Html;
use frontend\widgets\ReviewsBar;
use common\assets\FullCalendarAsset;
use yii\web\View;

FullCalendarAsset::register($this);
?>

<div class="user-cont girl-view">
    <div class="user-col">

        <div class="girl-profile">
            <div class="fields-top">
                <div class="field-name">
                    <?php if (\Yii::$app->user->can('nonAdvetiserProfile')) { ?><span class="fav-star<?=($model->isFavorit(\Yii::$app->user->getId()) ? ' on"' : '" title="'.Yii::t('app', 'Add to favorites').'"');?>></span><?php } ?>
                    <?= $model->user->username ?></div>
                <?php if (\Yii::$app->user->can('nonAdvetiserProfile') || \Yii::$app->user->getId() == $model->user_id) { ?>
					<a href="<?= \common\helpers\Calendar::url($model); ?>" class="link-datepicker fancy"><span><?= Yii::t('app', 'Calendar'); ?></span></a>
                <?php } ?>
            </div>
            <div class="field-short">“<?= $model->title ?>”</div>
            <div class="prof-cols">
                  <div class="col-photos">
                      <div class="main-photo">
                      <?php if (count($all_photos) > 0) { ?>
							<img src="<?= $default_photo ? $default_photo['big_url'] : ''; ?>" alt=""  class="gal">
                      <?php } ?>
                      </div>
                      <div class="thumbs">
          <?php
              $org_hrefs = array();
              foreach ($all_photos as $i => $photo) {
                  $org_hrefs[] = $photo['org_url'];
          ?>
              <div class="thumb">
								<img src="<?= $photo['small_url']; ?>" alt="" class="gal" data-index="<?= $i; ?>">
              </div>
          <?php
              }
          ?>
                      </div>
                </div>
                <div class="col-sett">
                    <div class="field-place">
						<?= Yii::t('app', 'Available now in {city}', ['city' => '<a href="#">' . ($model->city ? $model->city->title : '') . '</a>']); ?>
						<div class="filter-value"><?php echo Yii::t('app', '{scores} points', ['scores' => $model->points]); ?></div>
					</div>
                    <div class="filter-block">
                        <div class="filter-label"><?= Yii::t('app', 'Price'); ?>
                            <div class="filter-value"><?= $model->price ?> €/h</div>
                        </div>
                    </div>
                    <div class="filter-block">
                        <div class="filter-label filter-opener"><?= Yii::t('app', 'Extra cost'); ?></div>
                        <div class="filter-drop"></div>
                    </div>
                    <div class="filter-block">
                        <div class="filter-label"><?= Yii::t('app', 'Age'); ?>
                            <div class="filter-value"><?= $model->age ?> <?= Yii::t('app', 'y.o.'); ?></div>
                        </div>
                    </div>
                    <div class="filter-block">
                        <div class="filter-label">
							<?= Yii::t('app', 'Sex'); ?>
                          <div class="filter-value"><?= $model->sex ? $model->sex->title : ''; ?></div>
                        </div>
                    </div>
                    <div class="filter-block active">
                        <div class="filter-label filter-opener"><?= Yii::t('app', 'Appearance'); ?></div>
                        <div class="filter-drop">
                            <div class="f-row">
                                <label><?= Yii::t('app', 'Height'); ?></label>
                                <div class="filter-value"><?= $model->height ?> <?= Yii::t('app', 'cm'); ?></div>
                            </div>
                            <div class="f-row">
                                <label><?= Yii::t('app', 'Weight'); ?></label>
                                <div class="filter-value"><?= $model->weight ?> <?= Yii::t('app', 'kg'); ?></div>
                            </div>
                            <div class="f-row">
                                <label><?= Yii::t('app', 'Hair color'); ?></label>
                                <div class="filter-value">
                                    <span class="color <?= !empty($model->hair) ? $model->hair->class : '' ?>"></span><?= !empty($model->hair) ? Yii::t('app', $model->hair->title) : ''; ?>
                                </div>
                            </div>
                            <div class="f-row">
                                <label><?= Yii::t('app', 'Eye color'); ?></label>
                                <div class="filter-value">
                                    <span class="color <?= !empty($model->eye) ? $model->eye->class : '' ?>"></span><?= !empty($model->eye) ? Yii::t('app', $model->eye->title) : ''; ?>
                                </div>
                            </div>
                            <div class="f-row">
                                <label><?= Yii::t('app', 'Skin color'); ?></label>
                                <div class="filter-value">
                                    <span class="color <?= !empty($model->skin) ? $model->skin->class : '' ?>"></span><?= !empty($model->skin) ? Yii::t('app', $model->skin->title) : ''; ?>
                                </div>
                            </div>
                            <div class="f-row">
                                <label><?= Yii::t('app', 'Shoe size'); ?></label>
                                <div class="filter-value">
                                    <?= $model->shoe_size ?>
                                </div>
                            </div>
                            <div class="f-row">
                                <label><?= Yii::t('app', 'Bra size'); ?></label>
                                <div class="filter-value">
                                    <?= !empty($model->bra) ? $model->bra->title : '' ?>
                                </div>
                            </div>
                            <div class="f-row">
                                <div class="check">
                                    <label>
										<?= Html::checkbox('silicone', $model->silicone) ?>
                                        <?= Yii::t('app', 'Silicone breasts') ?>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="filter-block">
                        <div class="filter-label"><?= Yii::t('app', 'Nationality'); ?>
                            <div class="filter-value"><?= !empty($model->nationality) ? Yii::t('app', $model->nationality->title) : ''; ?></div>
                        </div>
                    </div>
                    <div class="filter-block">
                        <div class="filter-label filter-opener"><?= Yii::t('app', 'Services offering'); ?></div>
                        <div class="filter-drop white">
                            <?= $this->render('tags', ['models' => $model->offering_as_value]) ?>
                        </div>
                    </div>
                    <div class="filter-block">
                        <div class="filter-label filter-opener"><?= Yii::t('app', 'Services receiving'); ?></div>
                        <div class="filter-drop white">
                            <?= $this->render('tags', ['models' => $model->receiving_as_value]) ?>
                        </div>
                    </div>
                    <div class="filter-block">
                        <?=
                        ReviewsBar::widget([
                            'id'	 => $model->user->id,
                            'action' => 'advertiser',
                            'reply' => false
                        ])
                        ?>
                    </div>

                </div>
            </div>
            <div class="field-desc">
                <p><?= $model->desc ?></p>
            </div>
            <div class="sett-subm">
                <?= $template['bookingRequest'] ?>
                <?= $template['chat'] ?>
				<?= $this->render('/site/pop_up/pop_report_spam', ['model' => $model]); ?>
            </div>
        </div>
    </div>
</div>
<div>
	<?= $this->render('chat', ['model' => $model, 'chat' => $chat, 'template' => $template, 'message' => $message]); ?>
</div>
<div style="display:none;">
    <?= $this->render('/site/pop_up/pop_book_req', ['model' => $model]) ?>
    <?=
    $this->render('/site/pop_up/_pop_booking', [
        'template'	 => $template,
        'model'		 => $model,
    ]);
    ?>
    <?= $this->render('/site/pop_up/pop_book', ['template' => $template]) ?>
</div>
	<?php
  $js = '$(".gal").click(function() {
    $.fancybox(
      ["' . implode("\",\n\"", $org_hrefs) . '"],
      {
        "type": "image",
        "index": $(this).attr("data-index")
      }
    );
  });

  $(".fav-star").click(function() {
    $(this).toggleClass("on");
    $.post(
      "'.Yii::getAlias('@frontendWeb').'/site/change-favorit",
      {"adv":'.$model->id.'},
    function() { location.reload(); }
    );
  });
  ';
  $this->registerJs($js, View::POS_READY);
	