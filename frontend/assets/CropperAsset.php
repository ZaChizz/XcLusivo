<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class CropperAsset extends AssetBundle
{
    public $basePath = '@webroot/cropper';
    public $baseUrl = '@web/cropper';
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $css = [
        'cropper.min.css'
    ];
    public $js = [
        'cropper.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
