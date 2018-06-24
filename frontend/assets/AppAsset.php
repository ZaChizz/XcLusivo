<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        'css/slick.css',
        'css/jquery.formstyler.css',
        'css/jquery.mCustomScrollbar.css',
        'css/jquery.fancybox.css',


    ];
    public $js = [
        "js/jquery-ui.min.js",
        "js/jquery.ui.slider.js",
        "js/jquery.mCustomScrollbar.js",
        "js/jquery.formstyler.js",
        "js/slick.js",
        "js/jquery.fancybox.js",
        "js/main.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
