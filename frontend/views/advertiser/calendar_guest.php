<?php

/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 29.04.2016
 * Time: 13:24
 */
use yii\helpers\Html;
use frontend\widgets\ReviewsBar;
use frontend\widgets\AdvInfo;
use yii\web\View;
use common\assets\ProjectAsset;
use yii\helpers\Url;
use common\helpers\Toolbox;

ProjectAsset::register($this);
?>



<div class="girl-profile">
	<div class="fields-top">
		<div class="field-name"><?= $model->user->username ?></div>
	</div>

	<div id="calendar"></div>
</div>


<?php $this->registerJs("project.booking.initCalendar({
	events: '" . Url::toRoute(['booking/feed', 'id' => $model->id]) . "',
	bookingUrl: false,
	editable: false,
	selectable: false,
	dayClick: function(date, jsEvent, view) {
		project.flashMessage('".Toolbox::popupAuthMessage()."', project.FM_ERROR);
	}
});"); ?>
