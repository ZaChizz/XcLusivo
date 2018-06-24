<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SpamReports */

$this->title = 'Create Spam Reports';
$this->params['breadcrumbs'][] = ['label' => 'Spam Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spam-reports-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
