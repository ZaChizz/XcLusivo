<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 17.05.2016
 * Time: 1:40
 */

namespace frontend\widgets;

class FavoriteBar extends \yii\bootstrap\Widget
{
    public $model;

    public function init(){
        parent::init();

    }

    public function run(){

        return $this->render('FavoriteBar/index', ['model'=>$this->model]);

    }
}
?>