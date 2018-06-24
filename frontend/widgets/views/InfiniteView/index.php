<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 16.05.2016
 * Time: 14:45
 */

foreach($models as $model)
{
    echo $this->render('item', ['model'=>$model]);
}
