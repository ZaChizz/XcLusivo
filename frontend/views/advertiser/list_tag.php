<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 19.06.2016
 * Time: 2:11
 */
?>
<div class="tags editable" name="<?= $name ?>" value="<?=implode(',', $model_id);?>">
    <?php
    foreach ($model_services as $id => $name) {
        $name = Yii::t('app', $name);
        $isChecked = in_array($id, $model_id);
        ?>
        <label<?=($isChecked ? ' class="checked"' : '');?>>
          <input type="checkbox" value="<?=$id;?>"<?=($isChecked ? ' checked="checked"' : '');?>>
          <?=$name;?>
        </label>
    <?php
    }
    ?>
</div>
