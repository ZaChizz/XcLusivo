<div class="">
	<?php
	echo yii\widgets\ListView::widget([
		'id' => (!empty($id)) ? $id : 'a-booking-list',
		'dataProvider' => $provider,
		'layout' => empty($layout) ? '{items}' : $layout,
		'itemView' => '_booking_item_for_a',
	]);
	?>
</div>