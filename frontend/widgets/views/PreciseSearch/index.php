<?php

/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 28.04.2016
 * Time: 13:42
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\web\View;
use frontend\models\Bra;
use frontend\widgets\Choose;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;
?>
<div class="side-filter">
	<div class="filter-title"><?= Yii::t('app', 'Precise search'); ?></div>
	<div class="filter-cont">
		<?php
		$form = ActiveForm::begin(['id' => 'filter-form',
				'action' => ['site/index'], 'enableAjaxValidation' => true, 'method' => 'get']);
		?>
		<div class="filter-block pos-bottom-10px">
			<?= Html::activeInput('text', $model, 'name', ['placeholder' => Yii::t('app', 'Enter name'), 'class' => 't-inp']); ?>
		</div>
		<div class="filter-block">
			<?= Html::activeInput('text', $model, 'location', ['placeholder' => Yii::t('app', 'Enter location'), 'class' => 'inp-location'.(!$isFilled ? ' autodetect' : '')]); ?>
		</div>
		<div class="checks checks-cols">
			<?php
			if ($sex) {
				foreach ($sex as $item) {
					?>
					<div class="check">
						<label>
							<?= Html::checkbox("AdvertiserSearch[filtersex][]", in_array($item->id, $model->filtersex), ['value' => $item->id]); ?>
							<?= Yii::t('app', $item->title); ?>
						</label>
					</div>
					<?php
				}
			}
			?>
		</div>
		<div class="filter-block">
			<div class="filter-label"><?= Yii::t('app', 'Price'); ?>
				<div class="range-row">
					<?= Html::activeInput('text', $model, 'price_lower', ['placeholder' => Yii::t('app', 'from'), 'class' => 't-inp']) ?>
					<span>&mdash;</span>
					<?= Html::activeInput('text', $model, 'price_upper', ['placeholder' => Yii::t('app', 'to'), 'class' => 't-inp']) ?>
					<span> <?= Yii::t('app', 'y.o.'); ?></span>
				</div>
			</div>
		</div>
		<div class="filter-block">
			<div class="filter-label filter-date"><?= Yii::t('app', 'Date'); ?>
				<?=
				DateRangePicker::widget([
					'model' => $model,
					'attribute' => 'date_range',
					'convertFormat' => true,
					'options' => [
						'readonly' => 'readonly',
						'class' => 't-inp',
					],
					'pluginOptions' => [
						'timePicker' => true,
						'timePickerIncrement' => 60,
						'timePicker24Hour' => true,
						'locale' => [
							'format' => 'd/m/Y H:00',
						]
				]]);
				?>
			</div>
		</div>

		<?php /*
		  <div class="filter-block">
		  <div class="filter-label filter-date"><?= Yii::t('app', 'Date'); ?>
		  <?=
		  DatePicker::widget([
		  'name' => 'date',
		  'type' => DatePicker::TYPE_INPUT,
		  'value' => $model->date,
		  'pluginOptions' => [
		  'autoclose' => true,
		  'format' => 'yyyy-mm-dd'
		  ]
		  ]);
		  ?></div>
		  </div>
		 *
		 */ ?>
		<div class="filter-block">
			<div class="filter-label"><?= Yii::t('app', 'Age'); ?>
				<div class="range-row">
					<?= Html::activeInput('text', $model, 'age_lower', ['placeholder' => Yii::t('app', 'from'), 'class' => 't-inp']) ?>
					<span>&mdash;</span>
					<?= Html::activeInput('text', $model, 'age_upper', ['placeholder' => Yii::t('app', 'to'), 'class' => 't-inp']) ?>
					<span> <?= Yii::t('app', 'y.o.'); ?></span>
				</div>
			</div>
		</div>
		<div class="filter-block active">
			<div class="filter-label filter-opener"><?= Yii::t('app', 'Appearance'); ?></div>
			<div class="filter-drop">
				<div class="f-row">
					<label><?= Yii::t('app', 'Height'); ?></label><div class="range-row">
						<?= Html::activeInput('text', $model, 'height_lower', ['placeholder' => Yii::t('app', 'from'), 'class' => 't-inp']) ?>
						<span>&mdash;</span>
						<?= Html::activeInput('text', $model, 'height_upper', ['placeholder' => Yii::t('app', 'to'), 'class' => 't-inp']) ?>
						<span><?= Yii::t('app', 'cm'); ?></span>
					</div>
				</div>
				<div class="f-row">
					<label><?= Yii::t('app', 'Weight'); ?></label>
					<div class="range-row">
						<?= Html::activeInput('text', $model, 'weight_lower', ['placeholder' => Yii::t('app', 'from'), 'class' => 't-inp']) ?>
						<span>&mdash;</span>
						<?= Html::activeInput('text', $model, 'weight_upper', ['placeholder' => Yii::t('app', 'to'), 'class' => 't-inp']) ?>
						<span><?= Yii::t('app', 'kg'); ?></span>
					</div>
				</div>
				<div class="f-row">
					<label><?= Yii::t('app', 'Hair color'); ?></label>
					<div class="colors">
						<?= $this->render('colors_checkbox', ['model' => $model->color_hair, 'search_model' => $model->s_hair_id, 'name' => 's_hair_id']) ?>
					</div>
				</div>
				<div class="f-row">
					<label><?= Yii::t('app', 'Eye color'); ?></label>
					<div class="colors">
						<?= $this->render('colors_checkbox', ['model' => $model->color_eye, 'search_model' => $model->s_eye_id, 'name' => 's_eye_id']) ?>
					</div>
				</div>
				<div class="f-row">
					<label><?= Yii::t('app', 'Skin color'); ?></label>
					<div class="colors">
						<?= $this->render('colors_checkbox', ['model' => $model->color_skin, 'search_model' => $model->s_skin_id, 'name' => 's_skin_id']) ?>
					</div>
				</div>
				<div class="f-row">
					<label><?= Yii::t('app', 'Shoe size'); ?></label>
					<div class="range-row">
						<?= Html::activeInput('text', $model, 'shoe_size_lower', ['placeholder' => Yii::t('app', 'from'), 'class' => 't-inp']) ?>
						<span>&mdash;</span>
						<?= Html::activeInput('text', $model, 'shoe_size_upper', ['placeholder' => Yii::t('app', 'to'), 'class' => 't-inp']) ?>
					</div>
				</div>
				<div class="f-row">
					<label><?= Yii::t('app', 'Bra size'); ?></label>
					<div class="range-row">
						<?= $this->render('checkbox', ['model' => $model->bra_groups, 'search_model' => $model->s_bra_id, 'name' => 's_bra_id']) ?>
						<?php ?>
					</div>
				</div>
				<div class="f-row">
					<div class="check">
						<label>
							<?= Html::activeCheckbox($model, 'silicone') ?>
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="filter-block <?= count($model->s_nationality_id) ? 'active' : '' ?> ">
			<div class="filter-label filter-opener"><?= Yii::t('app', 'Nationality'); ?></div>
			<div class="filter-drop">
				<div class="checks checks-cols">
					<?=
					Choose::widget([
						'name' => 'AdvertiserSearch[s_nationality_id]',
						'value' => $model->s_nationality_id, // initial value
						'data' => $model->nationality_data,
						'maintainOrder' => true,
						'toggleAllSettings' => [
							'selectLabel' => '<i class="glyphicon glyphicon-ok-circle"></i> ' . Yii::t('app', 'Add All'),
							'unselectLabel' => '<i class="glyphicon glyphicon-remove-circle"></i> ' . Yii::t('app', 'Remove All'),
							'selectOptions' => ['class' => 'text-success'],
							'unselectOptions' => ['class' => 'text-danger'],
						],
						'options' => ['btnname' => Yii::t('app', '+ Add'), 'placeholder' => 'Choose a services ...', 'multiple' => true],
						'pluginOptions' => [
							'tags' => true,
							'maximumInputLength' => 10
						],
					]);
					?>

					<?php // $this->render('checkbox',['model'=>$model->nationality_data, 'search_model'=>$model->s_nationality_id, 'name'=>'s_nationality_id', ''])  ?>
				</div>
			</div>
		</div>
		<div class="filter-block <?= count($model->offering_as_id) ? 'active' : '' ?>">
			<div class="filter-label filter-opener"><?= Yii::t('app', 'Service offering'); ?></div>
			<div class="filter-drop">
				<?=
				Choose::widget([
					'name' => 'AdvertiserSearch[offering]',
					'value' => $model->offering_as_id, // initial value
					'data' => $model->services,
					'maintainOrder' => true,
					'toggleAllSettings' => [
						'selectLabel' => '<i class="glyphicon glyphicon-ok-circle"></i> ' . Yii::t('app', 'Add All'),
						'unselectLabel' => '<i class="glyphicon glyphicon-remove-circle"></i> ' . Yii::t('app', 'Remove All'),
						'selectOptions' => ['class' => 'text-success'],
						'unselectOptions' => ['class' => 'text-danger'],
					],
					'options' => ['btnname' => Yii::t('app', '+ Add'), 'placeholder' => 'Choose a services ...', 'multiple' => true],
					'pluginOptions' => [
						'tags' => true,
						'maximumInputLength' => 10
					],
				]);
				?>
			</div>
		</div>
		<div class="filter-block <?= count($model->receiving_as_id) ? 'active' : '' ?>">
			<div class="filter-label filter-opener"><?= Yii::t('app', 'Service receiving'); ?></div>
			<div class="filter-drop">
				<?=
				Choose::widget([
					'name' => 'AdvertiserSearch[receiving]',
					'value' => $model->receiving_as_id, // initial value
					'data' => $model->services,
					'maintainOrder' => true,
					'toggleAllSettings' => [
						'selectLabel' => '<i class="glyphicon glyphicon-ok-circle"></i> ' . Yii::t('app', 'Add All'),
						'unselectLabel' => '<i class="glyphicon glyphicon-remove-circle"></i> ' . Yii::t('app', 'Remove All'),
						'selectOptions' => ['class' => 'text-success'],
						'unselectOptions' => ['class' => 'text-danger'],
					],
					'options' => ['btnname' => Yii::t('app', '+ Add'), 'placeholder' => 'Choose a receiving ...', 'multiple' => true],
					'pluginOptions' => [
						'tags' => true,
						'maximumInputLength' => 10
					],
				]);
				?>
			</div>
		</div>
		<div class="filter-submit">
			<?= Html::a(Yii::t('app', 'Reset'), Url::to(['site/index']), ['class' => "link-cancel"]) ?>
			<?= Html::submitButton(Yii::t('app', 'Filter'), ['class' => 'btn btn-gray', 'name' => 'filter']) ?>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
<?php
ob_start();
?>
$(".color [type=checkbox]").bind("change",
	function() { $(this).parent().toggleClass("selected", this.checked); }
);

$(".inp-location")
	.bind("click", function() { this.setSelectionRange(0, this.value.length); })
	.autocomplete({
		source: function (request, response) {
			$.get("<?= Yii::getAlias('@frontendWeb'); ?>/site/city",
				{
					city: request.term
				},
				function (data) {
					response(data);
				}
			);
			},
			minLength:3
	});
<?php
$js = ob_get_contents();
ob_end_clean();

$this->registerJs($js, View::POS_READY);
