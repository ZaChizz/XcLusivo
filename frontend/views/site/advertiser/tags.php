<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 07.06.2016
 * Time: 19:22
 */

use yii\helpers\Html;
?>
<div class="tags">
    <?php
        foreach($models as $value)
        {
            echo Html::a(Yii::t('app', $value), '#', ['class' => 'select2-selection__choice']);
        }
    ?>
</div>
