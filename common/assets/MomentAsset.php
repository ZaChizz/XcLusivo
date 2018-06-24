<?php
/**
 * Moment Bundle (for dependencies)
 * 
 * @author Andriy Volberg <andriy.volberg@gmail.com>
 * 
 */

namespace common\assets;

use yii\web\AssetBundle;


class MomentAsset extends AssetBundle
{
	public $sourcePath = '@vendor/bower/moment/min';
    public $css = [
    ];
    public $js = [
		'moment-with-locales.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
