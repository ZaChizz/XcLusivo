<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Translation */

$this->title = 'Update Translation: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Translations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="translation-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
