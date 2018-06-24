<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Translation */

$this->title = 'Create Translation';
$this->params['breadcrumbs'][] = ['label' => 'Translations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="translation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
