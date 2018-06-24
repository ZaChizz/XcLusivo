<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 09.06.2016
 * Time: 1:39
 */
?>

<div class="acc-title opener <?= count($template['from'])?'active':''?>"><?=$reply ? Yii::t('app', 'My Reviews') : Yii::t('app', '{username}\'s reviews', ['username' => $username]);?><sup>(<?= count($template['from'])?>)</sup></div>
<div class="acc-drop <?= count($template['from'])?'active':''?>">
    <div class="revs scroll">
        <?= $this->render('list', ['models'=>$template['from']]) ?>
    </div>
</div>
<div class="acc-title opener <?= count($template['to'])?'active':''?>"><?=$reply ? Yii::t('app', 'Reviews given to me') : Yii::t('app', 'Reviews given to {username}', ['username' => $username]);?><sup>(<?= count($template['to'])?>)</sup></div>
<div class="acc-drop <?= count($template['to'])?'active':''?>">
    <div class="revs scroll">
        <?= $this->render('list', ['models'=>$template['to']]) ?>
    </div>
</div>
