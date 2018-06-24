<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Advetiser */

$this->title = Yii::t('app', 'Create Advetiser');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advetisers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="girl-profile">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
