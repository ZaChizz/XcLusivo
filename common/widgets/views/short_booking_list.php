<?php
use yii\grid\GridView;
?>
GRID HERE
<?php
echo GridView::widget([
    'dataProvider' => $provider,
	'layout' => '{items}',
    'columns' => $columns,
]);
?>
GRID END