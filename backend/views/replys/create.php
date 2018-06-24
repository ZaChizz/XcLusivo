<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Replys */

$this->title = Yii::t('app', 'Create Replys');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Replys'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="replys-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
