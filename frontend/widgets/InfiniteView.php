<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 16.05.2016
 * Time: 14:43
 */

namespace frontend\widgets;


use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


class InfiniteView extends \yii\bootstrap\Widget
{
    public $dataProvider;

    public function init(){
        parent::init();

    }

    public function run(){

        $models = $this->dataProvider->getModels();
        $keys = $this->dataProvider->getKeys();
        $rows = [];

        return $this->render('InfiniteView/index', ['models'=>$models]);

    }
}
?>