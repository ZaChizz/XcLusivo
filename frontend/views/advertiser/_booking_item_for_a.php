<?php

/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 29.05.2016
 * Time: 7:42
 */
use yii\helpers\Html;
use common\helpers\Toolbox;
?>

<div class="book-prev">
	<?= Html::a($model->user->username, \common\helpers\Toolbox::userPublicUrl($model->user)); ?>
	<br/>
	<?= common\helpers\Toolbox::formatDateTime($model->from_date); ?>
	<br>
	<?= common\helpers\Toolbox::formatDateTime($model->to_date); ?>

	<?php if ((!isset($showToolbar) || $showToolbar) && Toolbox::currentAdvertiser() && Toolbox::currentAdvertiser()->id == $model->advertiser->id) : ?>
		<div class="book-bar">
			<?php if ($model->status == \common\models\Booking::STATUS_PENDING) : ?>
				<?=
				Html::a(Yii::t('app', 'Approve'), '#', [
					'class' => 'js-booking-manage',
					'data-action' => 1,
					'data-href' => yii\helpers\Url::to(['booking/manage', 'id' => $model->id]),
				]);
				?>
				<?=
				Html::a(Yii::t('app', 'Decline'), '#', [
					'class' => 'js-booking-manage',
					'data-action' => 0,
					'data-href' => yii\helpers\Url::to(['booking/manage', 'id' => $model->id]),
				]);
				?>
			<?php endif; ?>
			<?=
			Html::a(Yii::t('app', 'Write a review'), ['advertiser/review', 'id' => $model->user->id], ['class' => 'fancy fancybox.ajax']);
			?>
		</div>
	<?php endif; ?>
</div>
