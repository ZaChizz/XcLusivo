<div class="girls">
	<?php
        if($writeReview)
            echo yii\widgets\ListView::widget([
                    'dataProvider' => $provider,
                    'layout' => '{items}',
                    'itemView' => '_booking_item_for_na_w_review',
            ]);
        else
            echo yii\widgets\ListView::widget([
                    'dataProvider' => $provider,
                    'layout' => '{items}',
                    'itemView' => '_booking_item_for_na',
            ]);
	?>
</div>
<?php if ($needShowMore) : ?>

	<a href="#TODO-URL" class="btn"><?php echo Yii::t('app', 'Show More'); ?></a>
<?php endif; ?>
