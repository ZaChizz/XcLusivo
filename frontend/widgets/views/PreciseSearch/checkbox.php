<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 19.06.2016
 * Time: 13:37
 */

use yii\helpers\Html;

foreach ($model as $id => $title) {
    $isChecked = in_array($id, $search_model);
    ?>
    <div class="check">
        <label>
          <input type="checkbox" value="<?= $id ?>" name="AdvertiserSearch[<?=$name?>][]" <?=($isChecked ? ' checked="checked"' : '');?>>
          <?=Yii::t('app', $title);?>
        </label>
    </div>
<?php
}
