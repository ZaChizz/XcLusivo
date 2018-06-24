<?php

/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 29.04.2016
 * Time: 13:24
 */
use yii\helpers\Html;
use frontend\widgets\ReviewsBar;
use frontend\widgets\AdvInfo;
use yii\web\View;
use frontend\models\Chat;

$this->registerJsFile('/js/jquery.editable.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

echo AdvInfo::widget([
    'id' => $model->user->id,
    'advertiser' => $model
])
?>
<div class="girl-profile">
    <div class="fields-top">
        <div class="field-name">
            <a href="#"><?= $model->user->username; ?></a>
        </div>
        <a href="<?= \common\helpers\Calendar::url($model); ?>" class="link-datepicker fancy"><span><?=Yii::t('app', 'Calendar');?></span></a>
    </div>

    <div class="field-short">“<span data-name="title" data-origin="<?= $model->title; ?>" class="editable<?= empty($model->title) ? ' required' : ''; ?>"><?= $model->title; ?></span>” <a href="#" class="link-edit editable" data-edit-name="title"></a></div>
    <div class="prof-cols">
        <div class="col-photos">
            <div class="main-photo">
            <?php if (count($all_photos) > 0) { ?>
                <img src="<?=$default_photo ? $default_photo['big_url'] : '';?>" alt="" data-hash="<?=$default_photo ? $default_photo['hash'] : '';?>" data-origin="<?=$default_photo ? $default_photo['org_url'] : '';?>">
                <a href="#" class="link-edit"></a>
                <a href="#" class="link-remove"></a>
            <?php } else { ?>
                <a href="#pop-upload" class="fancy no-profile-photo"><?=Yii::t('app', 'Choose your profile photo');?></a>
            <?php } ?>
            </div>
            <div class="thumbs">
<?php
    $org_hrefs = array();
    foreach ($all_photos as $i => $photo) {
        $org_hrefs[] = $photo['org_url'];
?>
    <div class="thumb">
        <img src="<?=$photo['small_url'];?>" alt="" data-index="<?=$i;?>" data-hash="<?=$photo['hash'];?>" data-big-url="<?=$photo['big_url'];?>" data-origin="<?=$photo['org_url'];?>">
    </div>
<?php
    }
?>
              <a href="#pop-upload" class="add-photo fancy" title="<?=Yii::t('app', 'Upload photos');?>">+</a>
            </div>
        </div>
        <div class="col-sett">
            <div class="field-place filter-block">
                <?=Yii::t('app', 'Available now in');?>
                <span data-name="cities_id" data-origin="<?= isset($city_data[$model->cities_id]) ? $city_data[$model->cities_id] : ''; ?>" data-type="autocomplete" data-list="<?=Yii::getAlias('@frontendWeb');?>/site/city" class="editable <?= empty($model->cities_id) ? ' required' : ''; ?>">
                    <a href="#"><?= isset($city_data[$model->cities_id]) ? $city_data[$model->cities_id] : Yii::t('app', 'unknown'); ?></a>
                </span>
                <a href="#" class="link-edit editable" data-edit-name="cities_id"></a>
				<div class="filter-value"><?php echo Yii::t('app', '{scores} points', ['scores' => $model->points]); ?></div>
            </div>
            <div class="filter-block">
                <div class="filter-label">
                    <?=Yii::t('app', 'Price');?>
                    <a href="#" class="link-edit editable" data-edit-name="price"></a>
                    <div class="filter-value">
                        <span class="editable<?= empty($model->price) ? ' required' : ''; ?>" data-name="price" data-origin="<?= $model->price; ?>" data-type="number"><?= $model->price; ?></span> €/h
                    </div>
                </div>
            </div>
            <div class="filter-block">
                <div class="filter-label">
                    <?=Yii::t('app', 'Age');?>
                    <a href="#" class="link-edit editable" data-edit-name="age"></a>
                    <div class="filter-value">
                        <span class="editable<?= empty($model->age) ? ' required' : ''; ?>" data-name="age" data-origin="<?= $model->age; ?>" data-type="number"><?= $model->age; ?></span> <?=Yii::t('app', 'y.o.');?>
                    </div>
                </div>
            </div>
            <div class="filter-block">
                <div class="filter-label">
                  <?=Yii::t('app', 'Sex');?>
                  <a href="#" class="link-edit editable" data-edit-name="sex_id"></a>
                  <div class="filter-value editable<?= empty($model->sex_id) ? ' required' : ''; ?>" data-name="sex_id" data-origin="<?= $model->sex_id; ?>" data-type="selectbox" data-list="sex_list">
                      <?=$model->sex ? $model->sex->title : '';?>
                  </div>
                </div>
            </div>
            <div class="filter-block active">
                <div class="filter-label filter-opener"><?=Yii::t('app', 'Appearance');?></div>
                <div class="filter-drop">
                    <div class="f-row">
                        <label><?=Yii::t('app', 'Height');?></label>
                        <a href="#" class="link-edit editable" data-edit-name="height"></a>
                        <div class="filter-value">
                            <span class="editable<?= empty($model->height) ? ' required' : ''; ?>" data-name="height" data-origin="<?= $model->height; ?>" data-type="number"><?= $model->height; ?></span> <?=Yii::t('app', 'cm');?>
                        </div>
                    </div>
                    <div class="f-row">
                        <label><?=Yii::t('app', 'Weight');?></label>
                        <a href="#" class="link-edit editable" data-edit-name="weight"></a>
                        <div class="filter-value">
                            <span class="editable<?= empty($model->weight) ? ' required' : ''; ?>" data-name="weight" data-origin="<?= $model->weight; ?>" data-type="number"><?= $model->weight; ?></span> <?=Yii::t('app', 'kg');?>
                        </div>
                    </div>
                    <div class="f-row">
                        <label><?=Yii::t('app', 'Hair color');?></label>
                        <a href="#" class="link-edit editable" data-edit-name="hair_id"></a>
                        <div class="filter-value editable<?= empty($model->hair_id) ? ' required' : ''; ?>" data-name="hair_id" data-origin="<?= $model->hair_id; ?>" data-type="colorpicker" data-list="hair_colors">
                            <span class="color <?=isset($color_data->hair[$model->hair_id]) ? $color_data->hair[$model->hair_id]['class'] : ''; ?>"></span><?= isset($color_data->hair[$model->hair_id]) ? $color_data->hair[$model->hair_id]['name'] : ''; ?>
                        </div>
                    </div>
                    <div class="f-row">
                        <label><?=Yii::t('app', 'Eye color');?></label>
                        <a href="#" class="link-edit editable" data-edit-name="eye_id"></a>
                        <div class="filter-value editable<?= empty($model->eye_id) ? ' required' : ''; ?>" data-name="eye_id" data-origin="<?= $model->eye_id; ?>" data-type="colorpicker" data-list="eye_colors">
                            <span class="color <?=isset($color_data->eye[$model->eye_id]) ? $color_data->eye[$model->eye_id]['class'] : ''?>"></span><?= isset($color_data->eye[$model->eye_id]) ? $color_data->eye[$model->eye_id]['name'] : ''; ?>
                        </div>
                    </div>
                    <div class="f-row">
                        <label><?=Yii::t('app', 'Skin color');?></label>
                        <a href="#" class="link-edit editable" data-edit-name="skin_id"></a>
                        <div class="filter-value editable<?= empty($model->skin_id) ? ' required' : ''; ?>" data-name="skin_id" data-origin="<?= $model->skin_id; ?>" data-type="colorpicker" data-list="skin_colors">
                            <span class="color <?=isset($color_data->skin[$model->skin_id]) ? $color_data->skin[$model->skin_id]['class'] : ''?>"></span><?= isset($color_data->skin[$model->skin_id]) ? $color_data->skin[$model->skin_id]['name'] : ''; ?>
                        </div>
                    </div>
                    <div class="f-row">
                        <label><?=Yii::t('app', 'Shoe size');?></label>
                        <a href="#" class="link-edit editable" data-edit-name="shoe_size"></a>
                        <div class="filter-value editable<?= empty($model->shoe_size) ? ' required' : ''; ?>" data-name="shoe_size" data-origin="<?= !empty($model->shoe_size) ? $model->shoe_size : '' ?>" data-type="number">
                            <?= !empty($model->shoe_size) ? $model->shoe_size : '' ?>
                        </div>
                    </div>
                    <div class="f-row">
                        <label><?=Yii::t('app', 'Bra size');?></label>
                        <a href="#" class="link-edit editable" data-edit-name="bra_id"></a>
                        <div class="filter-value editable<?= empty($model->bra_id) ? ' required' : ''; ?>" data-name="bra_id" data-origin="<?= $model->bra_id ?>" data-type="selectbox" data-list="bra_data">
                            <?= !empty($model->bra) ? $model->bra->title : '' ?>
                        </div>
                    </div>
                    <div class="f-row">
                        <div class="check">
                            <label>
                                <?= Html::checkbox('silicone', $model->silicone, ['class'=>'editable'])?>
                                <?= Yii::t('app','Silicone breasts') ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="filter-block">
                <div class="filter-label">
                    <?=Yii::t('app', 'Nationality');?>
                    <a href="#" class="link-edit editable" data-edit-name="nationality_id"></a>
                    <div class="filter-value editable<?= empty($model->nationality_id) ? ' required' : ''; ?>" data-name="nationality_id" data-origin="<?= $model->nationality_id; ?>" data-type="selectbox" data-list="nations_list"><?= isset($nationality_data[$model->nationality_id]) ? $nationality_data[$model->nationality_id] : ''; ?></div>
                </div>
            </div>
            <div class="filter-block">
                <div class="filter-label filter-opener"><?=Yii::t('app', 'Services offering');?></div>
                <div class="filter-drop white">
                    <?= $this->render('list_tag', ['model_id' => $model->offering_as_id, 'model_services' => $model->services, 'name' => 'offering']) ?>
                </div>
            </div>
            <div class="filter-block">
                <div class="filter-label filter-opener"><?=Yii::t('app', 'Services receiving');?></div>
                <div class="filter-drop white">
                    <?= $this->render('list_tag', ['model_id' => $model->receiving_as_id, 'model_services' => $model->services, 'name' => 'receiving']) ?>
                </div>
            </div>
            <div class="filter-block">
                <?=
                ReviewsBar::widget([
                    'id'	 => Yii::$app->getUser()->id,
                    'action' => 'advertiser'
                ])
                ?>
            </div>
<!--            <a href="#pop-clnd" class="link-datepicker fancy"><span>Calendar Old</span></a> -->
        </div>
    </div>
    <div class="field-desc">
        <a href="#" class="link-edit editable" data-edit-name="desc"></a>
        <p data-name="desc" data-type="textarea" data-placeholder="<?=Yii::t('app', 'Tell us about yourself');?>" data-origin="<?= $model->desc; ?>" class="editable<?= empty($model->desc) ? ' required' : ''; ?>"><?= $model->desc; ?></p>
    </div>
    <div class="sett-subm">
        <?=Html::a(Yii::t('app', 'Start chat with Admin'), ['site/chat', 'id' => Chat::getChatWithAdmin($model->user_id)->id], ['class' => 'fancy fancybox.ajax link-chat', 'onClick' => 'function() { return false; }']);?>
    </div>

</div>

<div style="display:none;">
    <?= $this->render('/site/pop_up/pop_book_req', ['model' => $model]) ?>
    <?= $this->render('/site/pop_up/pop_clnd', ['template' => $template]) ?>
    <?= $this->render('/site/pop_up/pop_book', ['template' => $template]) ?>
    <?= $this->render('/site/pop_up/pop_upload') ?>
    <div class="pop-up" id="pop-image-editor">
        <div class="pop-title title-photo"><?=Yii::t('app', 'Edit photo');?></div>
        <div class="mess-form">
            <img id="edit-image">

<?php /* поворот происходит на сервере
            <div class="btn-group" id="cropper-toolbar">
              <input type="button" class="btn btn-gray" id="rotate-left" title="Rotate Left" value="Rotate Left">
              <input type="button" class="btn btn-gray" id="rotate-right" title="Rotate Right" value="Rotate Right">
            </div>
*/ ?>
        </div>
        <div class="mess-submit">
            <a href="#" class="btn btn-gray" id="cancel-image-edit"><?=Yii::t('app', 'Cancel');?></a>
            <input type="button" class="btn btn-primary" id="crop-button" value="Crop">
            <input type="submit" value="Save" class="btn" id="save-crop-photo">
        </div>
    </div>
</div>

<div style="position:absolute;left:0;top:-9999px;">
    <?= $this->render('/site/pop_up/pop_chat') ?>
</div>

<script>
    var hair_colors = <?= json_encode($color_data['hair']); ?>;
    var eye_colors = <?= json_encode($color_data['eye']); ?>;
    var skin_colors = <?= json_encode($color_data['skin']); ?>;
    var nations_list = <?= json_encode($nationality_data); ?>;
    var services_list = <?= json_encode($model->services); ?>;
    var bra_data = <?= json_encode($bra_data); ?>;
    var sex_list = <?=json_encode(\frontend\models\Sex::asArray());?>

    function deletePhoto(imgUrl) {
        var img = $('[data-origin="' + imgUrl + '"]', '.thumb');
        $.confirm({
            title: '<?=Yii::t('app', 'Delete photo');?>',
            columnClass:'confirm-delete',
            content: '<?=Yii::t('app', 'Delete this photo?');?><br><img style="max-width:340px;max-height:400px" src="' + imgUrl + '">',
            confirm: function(){
                $.post(
                    "<?=Yii::getAlias('@frontendWeb');?>/advertiser/delete-image",
                    { "hash":img.attr('data-hash') },
                    function() { location.reload(); }
                );
            },
            cancel: function(){}
        });
    }

    function editPhoto(imgUrl) {
        runImageEditor(imgUrl);
    }

    function setAsDefault(imgUrl) {
      var img = $('[data-origin="' + imgUrl + '"]', '.thumb');
      if (img.length > 0) {
        $.post(
          "<?=Yii::getAlias('@frontendWeb');?>/advertiser/image-set-as-default",
          { "hash":img.attr('data-hash') },
          function() { location.reload(); }
        );
      }
    }
</script>
<?php
    ob_start();
?>

    $(".editable").editable("<?=\Yii::$app->request->csrfToken;?>", "Advertiser");
    $(".main-photo .link-remove").click(function() { deletePhoto($(".main-photo img").attr("data-origin")); });
    $(".main-photo .link-edit").click(function() { editPhoto($(".main-photo img").attr("data-origin")); });
    $(".thumb img").click(function() {
        $.fancybox([
<?php
    echo "'",implode("',\n'", $org_hrefs),"'";
?>
      ],{
       "type": "image",
       "index": $(this).attr("data-index"),
       "closeBtn":false,
       "arrows" : false,
       "tpl": {
         "image": '<img class="fancybox-image" src="{href}" alt="" /><a href="#" class="link-remove" onClick="deletePhoto($(\'.fancybox-image\').attr(\'src\'))" title="<?=Yii::t('app', 'Delete photo');?>"></a> <a href="#" class="link-edit"  onClick="editPhoto($(\'.fancybox-image\').attr(\'src\'))" title="<?=Yii::t('app', 'Edit photo');?>"></a> <a href="#" onClick="setAsDefault($(\'.fancybox-image\').attr(\'src\'))" class="link-set-as-default"><?=Yii::t('app', 'Set as a profile picture');?></a>',
        }
      }
    );
  });
<?php
    $js_content = ob_get_contents();
    ob_end_clean();
    $this->registerJs($js_content, View::POS_READY);
