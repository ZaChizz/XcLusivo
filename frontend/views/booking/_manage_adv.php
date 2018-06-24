<div class="adv-booking-data js-adv-booking-data text-center">

	<p class=""> 
		<?= \yii\helpers\Html::a($model->user->username, common\helpers\Toolbox::userPublicUrl($model->user), ['target' => '_blank']); ?>
	</p>

	<p class="booking-status booking-status-<?= strtolower($model->status); ?>"><?= Yii::t('app', $model->status); ?></p>

	<p class="nowrap">
		<?= common\helpers\Toolbox::formatDateTime($model->from_date); ?>
		-
		<?= common\helpers\Toolbox::formatDateTime($model->to_date); ?>
	</p>

	<p>
		<?=
		\yii\helpers\Html::a(Yii::t('app', 'Confirm Booking'), '#', [
			'class' => 'btn btn-success js-booking-manage',
			'data-href' => \yii\helpers\Url::to(['booking/manage', 'id' => $model->id]),
			'data-action' => '1',
		]);
		?>
		<?=
		\yii\helpers\Html::a(Yii::t('app', 'Cancel (Remove) Booking'), '#', [
			'class' => 'btn btn-gray js-booking-manage',
			'data-href' => \yii\helpers\Url::to(['booking/manage', 'id' => $model->id]),
			'data-action' => '0',
		]);
		?>
	</p>

</div>

