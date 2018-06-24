<?php


namespace common\assets;

use yii\web\AssetBundle;


/**
 * Full Calendar bundle http://fullcalendar.io/download/
 * 
 * @author Andriy Volberg <andriy.volberg@gmail.com>
 * 
 */
class FullCalendarAsset extends AssetBundle
{

	public $sourcePath	 = '@vendor/bower/fullcalendar/dist';
	public $css			 = [
		//YII_ENV_DEV ? 'fullcalendar.css' : 'fullcalendar.min.css',
		'fullcalendar.min.css'
	];
	public $js			 = [
//		YII_ENV_DEV ? 'fullcalendar.js' : 'fullcalendar.min.js',
		'fullcalendar.min.js',
		'lang-all.js',
	];
	public $depends		 = [
		'yii\web\YiiAsset',
//		'yii\bootstrap\BootstrapAsset',
		'common\assets\MomentAsset',
	];

}
