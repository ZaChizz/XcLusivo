<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 25.04.2016
 * Time: 21:06
 */

namespace frontend\widgets;


class LoginBar extends \yii\bootstrap\Widget
{
    public $model;

    public function init(){
        parent::init();

    }

    public function run(){

        return $this->render('LoginBar/index', ['model'=>$this->model]);

    }
}
?>