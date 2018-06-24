<?php


namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\View;
use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\assets\ProjectAsset;


class ShortBookingList extends Widget
{

	const MODE_ADVERTISER = 'adv';
	const MODE_NON_ADVERTISER = 'nadv';

	public $query;
	public $limit = 3;
	public $showMoreLink = false;
	public $showMoreTitle = 'Show More';
	public $viewer = null;


	public function init()
	{
		parent::init();

		if (!($this->query instanceof ActiveQuery)) {
			throw new \yii\base\Exception('ActiveQuery instance required.');
		}

		if ($this->viewer) {
			if ($this->viewer == 'auto') {
				$this->viewer = \common\helpers\Toolbox::currentUser();
			} elseif (!($this->viewer instanceof User)) {
				throw new \yii\base\Exception('Viewer property must be an instance of common\models\User');
			}
		}
	}


	public function run()
	{
		$params = [
			'limit'			 => $this->limit,
			'needShowMore'	 => false,
			'showMoreLink'	 => $this->showMoreLink,
		];


		if ($this->limit) {
			if ($this->showMoreLink) {
				$totalCount = $this->query->count();
				$params['needShowMore'] = $needShowMore = $totalCount > $this->limit;
			}

			$this->query->limit = $this->limit;
		}

		$this->query->with(['advertiser.user', 'user']);
		$params['provider'] = new ActiveDataProvider(['query' => $this->query]);

		$columns = [];

		if ($this->viewer) {
			$params['isAdvertiser'] = $isAdv = (boolean) $this->viewer->params;

			if ($isAdv) {
				$columns[] = [
					'header' => Yii::t('app', 'Client'),
					'value'	 => 'user.username',
				];
			} else {
				$columns[] = [
					'header' => Yii::t('app', 'Advertiser'),
					'value'	 => 'advertiser.user.username',
				];
			}
		} else {

			$columns[] = [
				'header' => Yii::t('app', 'Advertiser'),
				'value'	 => 'advertiser.user.username',
			];

			$columns[] = [
				'header' => Yii::t('app', 'Client'),
				'value'	 => 'user.username',
			];
		}

		$columns[] = [
			'attribute'	 => 'from_date',
			'format'	 => ['date', 'php:m/d/Y H:i'],
		];

		$columns[] = [
			'attribute'	 => 'to_date',
			'format'	 => ['date', 'php:m/d/Y H:i'],
		];

		$columns[] = [
			'attribute' => 'status',
		];

		$params['columns'] = $columns;

		
		return $this->render('short_booking_list', $params);
	}


}

/*
			[
				'class'	 => 'yii\grid\DataColumn', // can be omitted, as it is the default
				'value'	 => function ($data) {
					return 'alala'; // $data['name'] for array data, e.g. using SqlDataProvider.
				},
			],
 */