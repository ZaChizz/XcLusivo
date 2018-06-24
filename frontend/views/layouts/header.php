<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 28.04.2016
 * Time: 17:13
 */
use yii\web\View;
use yii\helpers\Html;

use frontend\widgets\LoginBar;
use frontend\widgets\SignUpBar;
use frontend\models\SignupForm;

use common\models\LoginForm;

?>

<header id="header">
    <div class="cont-in">
        <div class="filter-btn"></div>
        <div class="head-logo"><?= Html::a(Html::img(Yii::getAlias('@frontendImages/logo.png')),['site/index'],['class'=>'logo']) ?></div>
        <div class="head-lang">

            <?= \lajax\languagepicker\widgets\LanguagePicker::widget([
                'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_BUTTON,
                'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_LARGE,
                'itemTemplate' => '<a href="{link}"><img src="'. Yii::getAlias('@frontendImages/icons/flag_{language}.jpg').'" alt="{language}" /></a>',
                'activeItemTemplate' => '<a href="{link}" class="current"><img src="'. Yii::getAlias('@frontendImages/icons/flag_{language}.jpg').'" alt="{language}" /></a>',
                'parentTemplate' => '<div class="flags">{items}</div>'
            ]); ?>

            <?= \lajax\languagepicker\widgets\LanguagePicker::widget([
                'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_BUTTON,
                'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_LARGE,
                'itemTemplate' => '<option class="op_{language}" value="{link}">{name}</option>',
                'activeItemTemplate' => '<option class="op_{language}" value="{link}" selected="selected">{name}</option>',
                'parentTemplate' => '<select onChange="window.location = this.value">{items}</select>'
            ]); ?>
        </div>
        <div class="head-login">
            <?php if(\Yii::$app->user->isGuest):?>
                <i class="log-op log-op1"></i>
                <a href="#" class="head-link" id="head-link1"><?=Yii::t('app', 'Login');?></a> / <a href="#" class="head-link" id="head-link2"><?=Yii::t('app', 'Sign Up');?></a>

                <?= LoginBar::widget([
                    'model' => new LoginForm()
                ])
                ?>

                <?= SignUpBar::widget([
                    'model' => new SignupForm()
                ])
                ?>

            <?php else :?>
                <i class="log-op log-op3"></i>
                <a href="#" class="head-link" id="head-link3"><?=\Yii::t('app', 'Hi, {username}', ['username' => Yii::$app->user->identity->username]); ?></a>
                <span class="user-location"></span>
                <div class="log-drop log-drop3">
                    <div class="mob-name"><?=Yii::t('app', 'Hi, {username}', ['username' => Yii::$app->user->identity->username]); ?></div>
                    <?php
                          if (\Yii::$app->user->can('advetiserProfile')) {
                              echo Html::a(Yii::t('app', 'My Profile'), ['advertiser/advertiser-profile'], array('class' => 'head-link'));
                          } elseif (\Yii::$app->user->can('nonAdvetiserProfile')) {
                              echo Html::a(Yii::t('app', 'My Profile'), ['non-advertiser/non-advertiser-profile'], array('class' => 'head-link'));
                          }
                          if (\Yii::$app->user->can('admin')) {
                              echo Html::a(Yii::t('app', 'Manage'),'site/admin');
                          }
                    ?>
                    <a href="<?= \yii\helpers\Url::toRoute('site/logout');?>" class="btn btn-violet"><?= \Yii::t('app', 'Log out') ?></a>
                    <a href="#" class="close"></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="cover"></div>
</header>
<?php
 ob_start();
?>
function getGeoLocation() {
    $.ajax( {
      url: '//freegeoip.net/json/',
      type: 'POST',
      dataType: 'jsonp',
      success: function(location) {
          var location =location.city + (location.city != "" ? ", " : "") + location.country_name;
          $(".user-location").text(location);
          var loc = $("#advertisersearch-location").val();
          if ($("#advertisersearch-location").hasClass("autodetect") && (loc == "" || loc == $("#advertisersearch-location").prop("placeholder"))) {
            $("#advertisersearch-location").val(location);
          }
      }
    });
}

getGeoLocation();
<?php
    $js = ob_get_contents();
    ob_end_clean();
    $this->registerJs($js, View::POS_READY);
