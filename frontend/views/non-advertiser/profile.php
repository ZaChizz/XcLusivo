<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 06.05.2016
 * Time: 21:07
 */

use frontend\widgets\ReviewsBar;
use frontend\widgets\NonAdvInfo;
use yii\web\View;
use yii\helpers\Html;

$this->registerJsFile(Yii::getAlias('@frontendWeb').'/js/jquery.editable.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJs('$(".editable").editable("'.\Yii::$app->request->csrfToken.'", "NonAdvertiser");', View::POS_READY);

?>
<div class="user-col">
		<?=NonAdvInfo::widget([
			'user' => $model,
			'payments' => $payments
		]); ?>

		<div class="reviews-col">
		<?= \frontend\widgets\ReviewsBar::widget([
		'id' => $model->id
		])
		?>
		</div>
</div>
<div class="booking-col">
	<?php if ($isOwn) { ?>
	<div class="col-top"></div>
	<div class="acc-title opener <?= $model->bookingActiveCount ? 'active':''?>"><?= Yii::t('app', 'Active Bookings');?><sup>(<?= $model->bookingActiveCount; ?>)</sup></div>
	<div class="acc-drop <?= $model->bookingActiveCount ?'active':''?>">
			<div class="scroll">
			<?php echo \common\widgets\NonAdvBookingList::widget([
				'query' => $model->getBookingActiveQuery(),
			]); ?>
			</div>
	</div>

	<div class="acc-title opener <?= $model->bookingPendingCount ? 'active':''?>"><?= Yii::t('app', 'Pending Requests');?><sup>(<?= $model->bookingPendingCount; ?>)</sup></div>
	<div class="acc-drop <?= $model->bookingPendingCount ?'active':''?>">
			<div class="scroll">
			<?php echo \common\widgets\NonAdvBookingList::widget([
				'query' => $model->getBookingPendingQuery(),
			]); ?>
			</div>
	</div>

	<div class="acc-title opener <?= $model->bookingPastCount ? 'active':''?>"><?= Yii::t('app', 'Past Bookings');?><sup>(<?= $model->bookingPastCount; ?>)</sup></div>
	<div class="acc-drop">
			<div class="scroll">
					<div class="girls">
			<?php echo \common\widgets\NonAdvBookingList::widget([
				'query' => $model->getBookingPastQuery(),
				'limit' => false,
				'showMoreLink' => false,
                                'writeReview' => Html::a(Yii::t('app','Write review'),'#')
			]); ?>
					</div>
			</div>
	</div>
	<?php } ?>
</div>

<?= $this->render('//site/pop_up/pop_review') ?>
<?= $this->render('//site/pop_up/pop_booking_list') ?>
