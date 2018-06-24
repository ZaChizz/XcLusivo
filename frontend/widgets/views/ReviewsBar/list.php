<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 09.06.2016
 * Time: 15:47
 */

 use yii\helpers\Html;
?>

<?php foreach($models as $model):?>
<div class="rev <?= $model['online']?>">
    <div class="rev-name"><?= $model['href']?></div>
    <div class="rev-txt"><?= $model['title']?></div>
    <?= $this->render('reply',['models'=>$model['reply']])?>
</div>
<?php endforeach ?>
