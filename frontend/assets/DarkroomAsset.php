<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class DarkroomAsset extends AssetBundle
{
    public $basePath = '@webroot/darkroom';
    public $baseUrl = '@web/darkroom';
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $css = [
        'css/darkroom.css'
    ];
    public $js = [
        'js/core/fabric.js',
        'js/darkroom.all.js',
        // 'js/core/utils.js',
        // 'js/core/ui.js',
        // 'js/core/transformation.js',
        // 'js/core/bootstrap.js',
        // 'js/core/plugin.js',
        // 'js/plugins/darkroom.crop.js',
        // 'js/plugins/darkroom.save.js',
        // 'js/plugins/darkroom.rotate.js',
        // 'js/plugins/darkroom.history.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
