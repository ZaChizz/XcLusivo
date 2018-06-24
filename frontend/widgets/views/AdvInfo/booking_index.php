<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 29.05.2016
 * Time: 7:02
 */
 use yii\web\View;
 use yii\helpers\Url;

  $js = 'function updateBookings() {
    $.get("'.Url::to('/advertiser/bookings').'", function (data) {
      if (data) {
        if (data["pending"]) {
            $("#book-pending-count").html(data["pending"]["count"]);
            if (data["pending"]["count"] > 0) {
                $("#book-pending-count").addClass("red-bg").removeClass("hidden");
            } else {
                $("#book-pending-count").removeClass("red-bg").addClass("hidden");
            }
            $(".book-pending").html(data["pending"]["content"]);
        }
        if (data["active"]) {
            $("#book-active-count").html(data["active"]["count"]);
            if (data["active"]["count"] > 0) {
              $("#book-active-count").removeClass("hidden");
            } else {
              $("#book-active-count").addClass("hidden");
            }
            $(".book-active").html(data["active"]["content"]);
        }
      }
    });
    setTimeout(updateBookings, 10000);
  }

  updateBookings();';
  $this->registerJs($js, View::POS_READY);
?>
<ul class="info-drop">
    <li <?= empty($booking['STATUS_ACTIVE'])?'':'class="active"'; ?>>
		<a href="#" class="opener"><?=Yii::t('app', 'Pending requests');?> <span id="book-pending-count" class="hidden">0</span></a>
        <div class="info-drop scroll">
            <div class="book-prevs book-pending">
            </div>
        </div>
    </li>
    <li><a href="#" class="opener"><?=Yii::t('app', 'Active bookings');?> <span id="book-active-count" class="hidden">0</span></a>
        <div class="info-drop scroll">
            <div class="book-prevs book-active">
            </div>
        </div>
    </li>
    <li><a href="#" class="opener"><?=Yii::t('app', 'Earlier bookings');?> <?= $bqPast->count() > 0 ? $bqPast->count() : ''; ?></a>
        <div class="info-drop scroll">
            <div class="book-prevs">
				<?php echo $this->render('a_booking_list', [
					'id' => 'a-past-booking-list',
					'provider' => new \yii\data\ActiveDataProvider(['query' => $bqPast->orderBy('from_date DESC'), 'pagination' => ['pageSize' => 3]]),
				]); ?>
            </div>
        </div>
    </li>
</ul>
