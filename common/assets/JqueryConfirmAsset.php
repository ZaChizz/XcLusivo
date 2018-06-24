<?php
/**
 * Moment Bundle (for dependencies)
 * 
 * @author Andriy Volberg <andriy.volberg@gmail.com>
 * 
 */

namespace common\assets;

use yii\web\AssetBundle;


class JqueryConfirmAsset extends AssetBundle
{
	public $sourcePath = '@common/assets/js/jquery-confirm/dist';
    public $css = [
		'jquery-confirm.min.css'
    ];
    public $js = [
		'jquery-confirm.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
