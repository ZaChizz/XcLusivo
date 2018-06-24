<div class="nonadv-booking-data js-nonadv-booking-data text-center">

	<p class=""> 
		<?= Yii::t('booking', 'Booking to {user}', ['user' => \yii\helpers\Html::a($model->advertiser->user->username, common\helpers\Toolbox::userPublicUrl($model->advertiser->user), ['target' => '_blank'])]); ?>
	</p>

	<p class="booking-status booking-status-<?= strtolower($model->status); ?>"><?= Yii::t('app', $model->status); ?></p>

	<p class="nowrap">
		<?= common\helpers\Toolbox::formatDateTime($model->from_date); ?>
		-
		<?= common\helpers\Toolbox::formatDateTime($model->to_date); ?>
	</p>

	<p>
		<?= Yii::t('booking', 'Do you really want to cancel booking to {user}?', ['user' => \yii\helpers\Html::a($model->advertiser->user->username, common\helpers\Toolbox::userPublicUrl($model->advertiser->user), ['target' => '_blank'])]); ?>
	</p>

</div>

