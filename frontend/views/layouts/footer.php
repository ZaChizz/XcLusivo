<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 28.04.2016
 * Time: 17:04
 */
?>
<footer id="footer">
    <div class="foot-in">
        <div class="cont-in">
            <div class="foot-left">
                <div class="foot-links">
                    <a href="<?= \yii\helpers\Url::toRoute('site/page/terms');?>"><?=Yii::t('app', 'Terms of use');?></a>
                    <a href="<?= \yii\helpers\Url::toRoute('site/page/policy');?>"><?=Yii::t('app', 'Privacy Policy');?></a>
                    <a href="<?= \yii\helpers\Url::toRoute('site/contact');?>"><?=Yii::t('app', 'Contact Us');?></a></div>
                <div class="copy">© XClusivo.org</div>
            </div>
        </div>
    </div>
</footer>

<?= \common\widgets\Flash::widget(); ?>
