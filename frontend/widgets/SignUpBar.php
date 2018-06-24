<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 26.04.2016
 * Time: 12:09
 */


namespace frontend\widgets;


class SignUpBar extends \yii\bootstrap\Widget
{
    public $model;


    public function init(){
        parent::init();


    }

    public function run(){

        return $this->render('SignUpBar/index', ['model'=>$this->model]);

    }
}
?>