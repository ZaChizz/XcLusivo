<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            [
                'label' => \Yii::t('app', 'Status'),
                'value' => $model->status == 0 ? 'disabled' : 'enabled',
            ],
            'meta_title',
            'meta_desc',
            'meta_kw',
            [
                'label' => \Yii::t('app', 'Created'),
                'value' => date("F j, Y, g:i a", $model->created_at),
            ],
            [
                'label' => \Yii::t('app', 'Updated'),
                'value' => date("F j, Y, g:i a", $model->updated_at),
            ],
        ],
    ]) ?>

    <hr />
    <div class="nav-bars">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <?php foreach ($contents as $lang => $data) : ?>
                <li role="presentation" class="<?php echo isset($b) ? '' : 'active'; $b = true; ?>">
                    <a href="#<?= $lang; ?>" aria-controls="<?= $lang; ?>" role="tab" data-toggle="tab"><?= \backend\models\Pages::getLangName($lang); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <?php foreach ($contents as $lang => $data) : ?>
                <div role="tabpanel" class="tab-pane <?php echo isset($a) ? '' : 'active'; $a = true; ?>" id="<?= $lang; ?>">
                    <?= DetailView::widget([
                        'model' => $data,
                        'attributes' => [
                            [
                                'label' => \Yii::t('app', 'Language'),
                                'value' => \backend\models\Pages::getLangName($data->lang),
                            ],
                            [
                                'label' => \Yii::t('app', 'Status'),
                                'value' => $data->status == 0 ? 'disabled' : 'enabled',
                            ],
                            'name',
                            [
                                'label' => \Yii::t('app', 'Created'),
                                'value' => date("F j, Y, g:i a", $data->created_at),
                            ],
                            [
                                'label' => \Yii::t('app', 'Updated'),
                                'value' => date("F j, Y, g:i a", $data->updated_at),
                            ],
                        ],
                    ]) ?>
                    <div style="background-color: white">
                        <?= $data->content; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

</div>
