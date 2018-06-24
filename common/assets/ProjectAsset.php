<?php
/**
 * Moment Bundle (for dependencies)
 * 
 * @author Andriy Volberg <andriy.volberg@gmail.com>
 * 
 */

namespace common\assets;

use yii\web\AssetBundle;


class ProjectAsset extends AssetBundle
{
	public $sourcePath = '@common/assets/js';
    public $css = [
    ];
    public $js = [
		'project.js',
    ];
    public $depends = [
		'common\assets\FullCalendarAsset',
		'common\assets\JqueryConfirmAsset',
    ];
}
