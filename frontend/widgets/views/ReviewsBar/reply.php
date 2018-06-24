<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 09.06.2016
 * Time: 22:44
 */
?>
<?php if(!empty($models)):?>
<?php foreach($models as $model): ?>
        <?php if($model['reply']): ?>
            <div class="reply"><?= $model['reply']?></div>
            <?php else: ?>
            <div class="rev">
                <div class="rev-name user"><?= $model['href']?></div>
                <div class="rev-txt"><?= $model['title']?></div>
            </div>
            <?php endif ?>
<?php endforeach ?>
<?php endif ?>