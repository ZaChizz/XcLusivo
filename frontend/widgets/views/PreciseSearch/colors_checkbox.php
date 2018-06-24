<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 19.06.2016
 * Time: 13:37
 */

use yii\helpers\Html;
foreach ($model as $data) {
    $isChecked = in_array($data['id'], $search_model);
    ?>
    <label class="color <?=$data['class'];?> <?=($isChecked ? 'selected' : '');?>" title="<?=$data['title'];?>">
        <input type="checkbox" value="<?= $data['id']; ?>" name="AdvertiserSearch[<?=$name?>][]" <?=($isChecked ? ' checked="checked"' : '');?>>
    </label>
<?php
}
